<?php
declare(strict_types=1);

session_start();

// Always redirect auth failures back to admin login.
const LOGIN_REDIRECT = 'admin/login.php';

/**
 * Set an error flash message and redirect to login page.
 */
function failAuth(string $message): void
{
    $_SESSION['error'] = $message;
    header('Location: ' . LOGIN_REDIRECT);
    exit;
}

// Load GitHub OAuth configuration.
$github = require __DIR__ . '/config/github.php';

// 1) Validate OAuth callback error first.
if (isset($_GET['error'])) {
    failAuth('GitHub login was cancelled or denied.');
}

// 2) Validate required query parameters.
$code = $_GET['code'] ?? '';
$state = $_GET['state'] ?? '';

if (!is_string($code) || $code === '' || !is_string($state) || $state === '') {
    failAuth('Invalid GitHub callback request.');
}

// 3) Validate CSRF state token.
$sessionState = $_SESSION['github_oauth_state'] ?? '';
unset($_SESSION['github_oauth_state']);

if (!is_string($sessionState) || $sessionState === '' || !hash_equals($sessionState, $state)) {
    failAuth('Invalid OAuth state. Please try again.');
}

// 4) Exchange authorization code for access token.
$tokenRequest = curl_init($github['token_url']);
curl_setopt_array($tokenRequest, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'client_id' => $github['client_id'],
        'client_secret' => $github['client_secret'],
        'code' => $code,
        'redirect_uri' => $github['redirect_uri'],
    ], '', '&', PHP_QUERY_RFC3986),
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: php-mini-contact-website',
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);

$tokenRaw = curl_exec($tokenRequest);
$tokenHttpCode = (int) curl_getinfo($tokenRequest, CURLINFO_HTTP_CODE);
curl_close($tokenRequest);

if ($tokenRaw === false || $tokenHttpCode !== 200) {
    failAuth('Could not complete GitHub authentication. Please try again.');
}

$tokenData = json_decode($tokenRaw, true);

if (!is_array($tokenData) || empty($tokenData['access_token']) || !is_string($tokenData['access_token'])) {
    failAuth('Invalid token response from GitHub.');
}

$accessToken = $tokenData['access_token'];

// 5) Fetch the authenticated GitHub user profile.
$userRequest = curl_init($github['user_api_url']);
curl_setopt_array($userRequest, [
    CURLOPT_HTTPGET => true,
    CURLOPT_HTTPHEADER => [
        'Accept: application/vnd.github+json',
        'Authorization: Bearer ' . $accessToken,
        'User-Agent: php-mini-contact-website',
        'X-GitHub-Api-Version: 2022-11-28',
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);

$userRaw = curl_exec($userRequest);
$userHttpCode = (int) curl_getinfo($userRequest, CURLINFO_HTTP_CODE);
curl_close($userRequest);

if ($userRaw === false || $userHttpCode !== 200) {
    failAuth('Could not fetch GitHub profile. Please try again.');
}

$userData = json_decode($userRaw, true);
$githubUsername = $userData['login'] ?? '';

if (!is_string($githubUsername) || $githubUsername === '') {
    failAuth('GitHub account information is incomplete.');
}

// 6) Authorize access only for the predefined allowed GitHub username.
$allowedUsername = (string) ($github['allowed_username'] ?? '');

if ($allowedUsername === '' || !hash_equals(strtolower($allowedUsername), strtolower($githubUsername))) {
    failAuth('This GitHub account is not authorized for admin access.');
}

// 7) Successful login: harden session and store admin identity.
session_regenerate_id(true);
$_SESSION['admin'] = $githubUsername;

// 8) Redirect to existing protected admin dashboard.
header('Location: admin/dashboard.php');
exit;
