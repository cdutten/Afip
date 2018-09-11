<?php

namespace Afip;

use Dotenv\Dotenv;

class Authenticator
{
    /** @var array $credentials */
    private $credentials = [];

    public function __construct($path)
    {
        $this->loadCredentials($path);
    }

    /**
     * @param $path
     */
    protected function loadCredentials($path)
    {
        $taXml = simplexml_load_file($path);
        $this->credentials = (array) $taXml->credentials;
        $this->credentials['cuitRepresentada'] = getenv('AFIP_CUIT');
    }

    /**
     * Get credentials
     *
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}