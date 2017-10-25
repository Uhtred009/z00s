<?php

return [

    /*
     * Credentials for the user based provider
     */
    'credentials' => [
        'password_client_id' => env('PASSWORD_CLIENT_ID', ''),
        'password_client_secret' => env('PASSWORD_CLIENT_SECRET', ''),

        'provider' => Olymbytes\Z00s\Auth\Credentials\EnvFileProvider::class,
    ],

    /*
     * The url to get access token, refresh token, etc. from.
     */
    'oauth_token_url' => env('OAUTH_TOKEN_URL', ''),

    /*
     * The prefix that should be used for the z00s routes.
     */
    'route_prefix' => 'api',

    /*
     * The field to use as username.
     */
    'username_field' => 'email',
];
