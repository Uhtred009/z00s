<?php

namespace Olymbytes\Z00s\Auth\Credentials;

interface ProviderInterface
{
    /**
     * [getCredentials description]
     * @param  [type]      $user [description]
     * @return Credentials       [description]
     */
    public function getCredentials($user): Credentials;
}