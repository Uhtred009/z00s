<?php

namespace Olymbytes\Z00s\Auth;

use Zttp\Zttp;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Olymbytes\Z00s\Exceptions\InvalidCredentialsException;

class LoginProxy
{
    public function attemptLogin($username, $password)
    {
        event(new Attempting($this->getGuard(), compact('username', 'password'), false));

        $user = $this->getUserInstance()
            ->where($this->getUsernameField(), $username)
            ->first();

        if (is_null($user)) {
            throw new InvalidCredentialsException;
        }

        $response = $this->proxy('password', [
            'username' => $username,
            'password' => $password,
        ], $user);

        event(new Authenticated($this->getGuard(), $user));
        event(new Login($this->getGuard(), $user, false));

        return $response;
    }

    public function attemptRefresh($refreshToken)
    {
        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken,
        ]);
    }

    public function attemptLogout()
    {
        $user = Auth::user();

        $accessToken = $this->getAccessToken();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        event(new Logout($this->getGuard(), $user));
    }

    public function proxy($grantType, array $data = [], $user)
    {
        $data = array_merge($data, $this->getClientCredentials($user), [
            'grant_type' => $grantType,
        ]);

        $response = Zttp::post($this->getOauthTokenUrl(), $data);

        if (! $response->isSuccess()) {
            event(new Failed($this->getGuard(), $user, $data));
            throw new InvalidCredentialsException;
        }

        return array_only($response->json(), ['access_token', 'expires_in', 'refresh_token', 'token_type']);
    }

    /**
     * Get access token.
     *
     * @return object
     */
    protected function getAccessToken()
    {
        return Auth::user()->token();
    }

    /**
     * Get the client credentials from the provider.
     *
     * @return array
     */
    protected function getClientCredentials($user)
    {
        $credentialsProviderClass = config('z00s.credentials.provider');

        $credentials = (new $credentialsProviderClass())->getCredentials($user);

        return [
            'client_id'     => $credentials->getClientId(),
            'client_secret' => $credentials->getClientSecret(),
            'scope'         => $credentials->getScope(),
        ];
    }

    /**
     * Get the url to get the oauth tokens from.
     *
     * @return string
     */
    protected function getOauthTokenUrl()
    {
        return config('z00s.oauth_token_url');
    }

    /**
     * Get the user instance.
     *
     * @return object
     */
    protected function getUserInstance()
    {
        $userClass = config('auth.providers.users.model');
        return new $userClass;
    }

    /**
     * Get username field from the config.
     *
     * @return string
     */
    protected function getUsernameField()
    {
        return config('z00s.username_field');
    }

    /**
     * Get the guard
     *
     * @return string
     */
    protected function getGuard()
    {
        return auth()->guard();
    }
}
