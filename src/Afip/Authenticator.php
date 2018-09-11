<?php

namespace Afip;

class Authenticator implements AuthenticatorInterface
{
    /** @var array $credentials */
    private $credentials = [];
    private $path;
    private $service;
    /**
     * @var WSAAClient
     */
    private $wssaClient;

    public function __construct($path, WSAAClient $wssaClient)
    {
        $this->path = $path;
        $this->loadCredentials();
        $this->service = $wssaClient->getService();
        $this->wssaClient = $wssaClient;
    }

    /**
     * @param $path
     */
    protected function loadCredentials()
    {
        if (!file_exists($this->path . '/' . $this->service . '_TA.xml')) {
            $this->generateTA();
        }
        $taXml = simplexml_load_file($path);
        $this->credentials = (array)$taXml->credentials;
        $this->credentials['cuitRepresentada'] = $this->parserCuit($taXml);
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

    private function parserCuit($taXml)
    {
        return '';
    }

    private function generateTA()
    {
        $this->wssaClient->generateTA();
    }
}