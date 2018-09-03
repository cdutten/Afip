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
     * padronA4 constructor.
     *
     * @param $service
     */
    public function __construct($service)
    {
        $this->client = new \SoapClient($service);
    }

    public function __call($name, $arguments)
    {
           $arguments = array_merge(Auth::getCredentials(), $arguments);
        $this->client->$name($arguments);
    }
}