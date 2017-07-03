<?php

return [

    /*
     * Credentials for the user based provider
     */
    'credentials' => [
    	'password_client_id' => env('PASSWORD_CLIENT_ID', ''),
    	'password_client_secret' => env('PASSWORD_CLIENT_SECRET', ''),
    ],

    /*
     * Config based provider uses the credentials set in this file.
     * User based provider fetches the client id and secret from the user. 
     */
    'provider' => 'config',
];
