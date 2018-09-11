<?php

namespace Afip;


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
        $arguments = array_merge($credentials, $arguments);
        return $this->client->$name($arguments);
    }
}