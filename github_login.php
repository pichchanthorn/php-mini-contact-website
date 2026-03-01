<?php
declare(strict_types=1);

session_start();

// Load GitHub OAuth configuration.
$github = require __DIR__ . '/config/github.php';

// Generate a CSRF state token and store it in session before redirect.
$state = bin2hex(random_bytes(32));
$_SESSION['github_oauth_state'] = $state;

// Build authorization query for Authorization Code flow.
$query = http_build_query([
    'client_id' => $github['client_id'],
    'redirect_uri' => $github['redirect_uri'],
    'scope' => 'read:user',
    'state' => $state,
], '', '&', PHP_QUERY_RFC3986);

// Redirect user to GitHub authorize page.
header('Location: ' . $github['authorize_url'] . '?' . $query);
exit;
