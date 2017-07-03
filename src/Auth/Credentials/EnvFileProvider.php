<?php

namespace Olymbytes\Z00s\Auth\Credentials;

class EnvFileProvider implements ProviderInterface
{
    /**
     * Get credentials for the $user.
     * @param $user 
     * @return Credentials
     */
    public function getCredentials($user): Credentials
    {
        return new Credentials(config('z00s.credentials.password_client_id'), config('z00s.credentials.password_client_secret'));
    }
}