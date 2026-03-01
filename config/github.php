<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| GitHub OAuth Configuration
|--------------------------------------------------------------------------
*/

$githubClientId = 'Ov23liVm7FDrh1FCToEb';
$githubClientSecret = '5716227f7435d61229dae133fd42423f72038362';

if ($githubClientId === '' || $githubClientSecret === '') {
    throw new RuntimeException(
        'GitHub OAuth configuration is missing.'
    );
}

return [
    'client_id' => $githubClientId,
    'client_secret' => $githubClientSecret,

    'redirect_uri' => 'http://localhost/php-mini-contact-website/github_callback.php',

    'allowed_username' => 'pichchanthorn',

    'authorize_url' => 'https://github.com/login/oauth/authorize',
    'token_url' => 'https://github.com/login/oauth/access_token',
    'user_api_url' => 'https://api.github.com/user',
];