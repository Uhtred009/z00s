<?php

namespace Olymbytes\Z00s\Auth\Credentials;

class Credentials
{
    /**
     *  The client’s ID
     *
     * @var string
     */
    protected $client_id = null;

    /**
     *  The client’s secret
     *
     * @var string
     */
    protected $client_secret = null;

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
        return $this->client_id;
    }

    /**
     * Set the client’s ID
     *
     * @param string client_id
     *
     * @return self
     */
    public function setClientId(string $client_id)
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * Get the client’s secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Set the client’s secret
     *
     * @param string client_secret
     *
     * @return self
     */
    public function setClientSecret(string $client_secret)
    {
        $this->client_secret = $client_secret;

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
