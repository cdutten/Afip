<?php

namespace Afip;

use SimpleXMLElement;

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

    /**
     * Authenticator constructor.
     * @param $path
     * @param WSAAClient $wssaClient
     *
     * @return void
     */
    public function __construct($path, WSAAClient $wssaClient)
    {
        $this->path = $path;
        $this->wssaClient = $wssaClient;
        $this->service = $wssaClient->getService();
        $this->loadCredentials();
    }

    /**
     * Load the credentials from the {$this->service}_TA.xml
     * If not exits {$this->service}_TA.xml, it generates them
     *
     * @return void
     *
     * @throws Exception
     */
    protected function loadCredentials()
    {
        if (!file_exists($this->path . '/' . $this->service . '_TA.xml')) {
            $this->wssaClient->generateTA();
        }
        $taXml = simplexml_load_file($this->path . '/' . $this->service . '_TA.xml');
        $this->credentials = (array) $taXml->credentials;
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

    /**
     * Get the cuit from the loaded {$this->service}_TA.xml
     *
     * @param SimpleXMLElement $taXml
     *
     * @return string
     *
     * @throws Exception
     */
    private function parserCuit(SimpleXMLElement $taXml)
    {
        $destination = (string) $taXml->header->destination;
        preg_match("/\d+/", $destination, $match);
        if (! $match) {
            throw new Exception('Can\'t get the Cuit from TA');
        }
        return $match[0];
    }
}