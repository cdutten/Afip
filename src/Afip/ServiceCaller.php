<?php

namespace Afip;

use Afip\Authenticator as Auth;

class ServiceCaller
{
    /**
     * @var \SoapClient $client Client with the service
     */
    protected $client;

    /**
     * ServiceCaller constructor.
     *
     * @param $service
     */
    public function __construct($service)
    {
        $this->client = new \SoapClient($service);
        return $this;
    }

    public function __call($name, $arguments)
    {
        $arguments = array_merge(Auth::getCredentials(), $arguments);
        return $this->client->$name($arguments);
    }
}