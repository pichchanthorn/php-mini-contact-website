<?php
declare(strict_types=1);

/*
 |--------------------------------------------------------------------------
 | GitHub OAuth Configuration
 |--------------------------------------------------------------------------
 | Replace CLIENT_ID and CLIENT_SECRET with your real GitHub OAuth App
 | credentials. Keep CLIENT_SECRET private and do not commit real secrets.
 */

return [
    // GitHub OAuth App credentials.
    'client_id' => 'CLIENT_ID',
    'client_secret' => 'CLIENT_SECRET',

    // Must exactly match your GitHub OAuth App callback URL setting.
    'redirect_uri' => 'http://localhost/php-mini-contact-website/github_callback.php',

    // Only this GitHub username is allowed to sign in as admin.
    'allowed_username' => 'pichchanthorn',

    // GitHub OAuth endpoints.
    'authorize_url' => 'https://github.com/login/oauth/authorize',
    'token_url' => 'https://github.com/login/oauth/access_token',
    'user_api_url' => 'https://api.github.com/user',
];
