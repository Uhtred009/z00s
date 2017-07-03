<?php 

namespace Olymbytes\Z00s\Auth;

use Zttp\Zttp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Olymbytes\Z00s\Exceptions\InvalidCredentialsException;

class LoginProxy
{
	public function attemptLogin($email, $password)
	{
		$user = $this->getUserInstance()
			->where('email', $email)
			->first();

		if (is_null($user)) {
			throw new InvalidCredentialsException;
		}

		return $this->proxy('password', [
			'username' => $email,
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
		$accessToken = Auth::user()->token();

		$refreshToken = DB::table('oauth_refresh_tokens')
			->where('access_token_id', $accessToken->id)
			->update([
				'revoked' => true
			]);

		$accessToken->revoke();
	}

	public function proxy($grantType, array $data = [], $user)
	{
		$data = array_merge($data, $this->getClientCredentials(), [
			'grant_type'    => $grantType,
		]);

		$response = Zttp::post(url('oauth/token'), $data);

		if (!$response->isSuccess()) {
			throw new InvalidCredentialsException;
		}

		return array_only($response->json(), ['access_token', 'expires_in', 'refresh_token', 'token_type']);
	}

	protected function getUserInstance()
	{
		$userClass = config('auth.providers.users.model');
		return new $userClass;
	}

	/**
	 * Get the client credentials from the provider.
	 * 
	 * @return array
	 */
	protected function getClientCredentials()
	{
		$credentialsProviderClass = config('z00s.credentials.provider');

		$credentials = (new $credentialsProviderClass())->getCredentials($user);

		return [
			'client_id' 	=> $credentials->getClientId(),
			'client_secret' => $credentials->getClientSecret(),
		];
	}
}