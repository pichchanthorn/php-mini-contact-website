<?php
declare(strict_types=1);

/*
 |--------------------------------------------------------------------------
 | GitHub OAuth Configuration
 |--------------------------------------------------------------------------
 | Credentials are loaded from environment variables to avoid hardcoding
 | secrets in source control.
 */

$githubClientId = trim((string) getenv('GITHUB_CLIENT_ID'));
$githubClientSecret = trim((string) getenv('GITHUB_CLIENT_SECRET'));

if ($githubClientId === '' || $githubClientSecret === '') {
    throw new RuntimeException(
        'GitHub OAuth configuration is missing. Set GITHUB_CLIENT_ID and GITHUB_CLIENT_SECRET environment variables.'
    );
}

return [
    // GitHub OAuth App credentials.
    'client_id' => $githubClientId,
    'client_secret' => $githubClientSecret,

    // Must exactly match your GitHub OAuth App callback URL setting.
    'redirect_uri' => 'http://localhost/php-mini-contact-website/github_callback.php',

    // Only this GitHub username is allowed to sign in as admin.
    'allowed_username' => 'pichchanthorn',

    // GitHub OAuth endpoints.
    'authorize_url' => 'https://github.com/login/oauth/authorize',
    'token_url' => 'https://github.com/login/oauth/access_token',
    'user_api_url' => 'https://api.github.com/user',
];
