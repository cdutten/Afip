<?php

namespace Afip;

/**
 * Class ServiceCaller
 * @package Afip
 */
class ServiceCaller
{
    /**
     * @var \SoapClient $client Client with the service
     */
    protected $client;
    private $auth;

    /**
     * ServiceCaller constructor.
     *
     * @param string $service
     * @param AuthenticatorInterface $auth
     */
    public function __construct($service, AuthenticatorInterface $auth)
    {
        $this->auth = $auth;
        $this->client = new \SoapClient($service);
    }

    public function __call($name, $arguments)
    {
        $credentials = $this->auth->getCredentials();
        $arguments = array_merge($credentials, $arguments[0]);
        return $this->client->$name($arguments);
    }
}