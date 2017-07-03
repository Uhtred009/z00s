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
        return (new Credentials())
            ->setClientId(config('z00s.credentials.password_client_id'))
            ->setClientSecret(config('z00s.credentials.password_client_secret'));
    }
}