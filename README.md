# Out-of-the-box Login Proxy for your Laravel app

The `olymbytes/z00s` package allows you to easily add an api login proxy to your application.

All you have to do to get started is:

Update the `.env` file:
```php
PASSWORD_CLIENT_ID={clientId}
PASSWORD_CLIENT_SECRET={secret}
OAUTH_TOKEN_URL=http://example.org/oauth/token
```

```php
// Add this in your `routes/web.php`, where `AppController` link to your SPA controller.
Route::get('password/reset/{token}', 'AppController')->name('password.reset');
```

## Installation

You can install the package via composer:

```bash
$ composer require olymbytes/z00s
```

The package will automatically register itself.

You can publish the config with:
```bash
$ php artisan vendor:publish --provider="Olymbytes\Z00s\Z00sServiceProvider" --tag="config"
```


This is the contents of the published config file:
```php
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
```

## Testing
To do.

## Security

If you discover any security issues, please email mpj@foreno.dk instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
