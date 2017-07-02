<?php 

namespace Olymbytes\Z00s;

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
		]);
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

	public function proxy($grantType, array $data = [])
	{
		$data = array_merge($data, [
			'client_id'     => config('api.credentials.password_client_id'),
			'client_secret' => config('api.credentials.password_client_secret'),
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
}