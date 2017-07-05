<?php

namespace Olymbytes\Z00s\Auth\Credentials;

class Credentials
{
    /**
     *  The client’s ID
     *
     * @var string
     */
    protected $clientId = null;

    /**
     *  The client’s secret
     *
     * @var string
     */
    protected $clientSecret = null;

    /**
     *  A space-delimited list of requested scope permissions
     *
     * @var string
     */
    protected $scope = null;

    public function __construct(string $clientId = '', string $clientSecret = '')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Get the client’s ID
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set the client’s ID
     *
     * @param string clientId
     *
     * @return self
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get the client’s secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Set the client’s secret
     *
     * @param string clientSecret
     *
     * @return self
     */
    public function setClientSecret(string $clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * Get the requested scope permissions as a space-delimited list
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set the requested scope permissions as a space-delimited list
     *
     * @param string scope
     *
     * @return self
     */
    public function setScope(string $scope)
    {
        $this->scope = $scope;

        return $this;
    }
}
