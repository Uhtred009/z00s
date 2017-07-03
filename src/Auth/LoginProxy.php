<?php 

namespace Olymbytes\Z00s\Auth;

use Zttp\Zttp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Olymbytes\Z00s\Exceptions\InvalidCredentialsException;

class LoginProxy
{
	public function attemptLogin($username, $password)
	{
		$user = $this->getUserInstance()
			->where($this->getUsernameField(), $username)
			->first();

		if (is_null($user)) {
			throw new InvalidCredentialsException;
		}

		return $this->proxy('password', [
			'username' => $username,
			'password' => $password,
		], $user);
	}

	public function attemptRefresh($refreshToken)
	{
		return $this->proxy('refresh_token', [
			'refresh_token' => $refreshToken,
		]);
	}

	public function attemptLogout()
	{
		$accessToken = $this->getAccessToken();

		$refreshToken = DB::table('oauth_refresh_tokens')
			->where('access_token_id', $accessToken->id)
			->update([
				'revoked' => true
			]);

		$accessToken->revoke();
	}

	public function proxy($grantType, array $data = [], $user)
	{
		$data = array_merge($data, $this->getClientCredentials($user), [
			'grant_type'    => $grantType,
		]);

		$response = Zttp::post(url('oauth/token'), $data);

		if (!$response->isSuccess()) {
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
			'client_id' 	=> $credentials->getClientId(),
			'client_secret' => $credentials->getClientSecret(),
		];
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
}