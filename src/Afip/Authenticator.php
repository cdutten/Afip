<?php

namespace Afip;

use SimpleXMLElement;

class Authenticator implements AuthenticatorInterface
{
    /** @var array $credentials */
    private $credentials = [];
    /** @var string Path to secret */
    private $path;
    /** @var string Service to Call */
    private $service;
    /** @var WSAAClient */
    private $wsaaClient;

    /**
     * Authenticator constructor.
     * @param $path
     * @param WSAAClient $wssaClient
     *
     * @throws Exception
     */
    public function __construct($path, WSAAClient $wssaClient)
    {
        if (!is_dir($path)) {
            throw new Exception('El path no se encuentra, utilice path absoluto, path: ' . $path);
        }

        $this->service = $wssaClient->getService();
        $this->path = $path;
        $this->wsaaClient = $wssaClient;
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
        if (! file_exists($this->path . '/' . $this->service . '_TA.xml')) {
            $this->wsaaClient->generateTA();
        }
        $taXml = simplexml_load_file($this->path . '/' . $this->service . '_TA.xml');
        $expirationTime = $this->convertToUTC($taXml->header->expirationTime);

        if ($expirationTime < date('c')) {
            $this->wsaaClient->generateTA();
            $taXml = simplexml_load_file($this->path . '/' . $this->service . '_TA.xml');
        }

        $this->credentials = (array) $taXml->credentials;
        $this->credentials['cuitRepresentada'] = $this->extractCuitFromTa($taXml);
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
     * @param SimpleXMLElement $taXml Ta auth file
     *
     * @return string
     *
     * @throws Exception
     */
    private function extractCuitFromTa(SimpleXMLElement $taXml)
    {
        $destination = (string) $taXml->header->destination;
        preg_match('/\d+/', $destination, $match);
        if ($match === false) {
            throw new Exception('Can\'t get the Cuit from TA');
        }

        return $match[0];
    }


    /**
     * Converts a date to UTC timezone
     *
     * @param string        $date Date to format
     *
     * @return \DateTime          Formated DateTime
     *
     * @throws \Exception
     */
    private function convertToUTC($date)
    {
        return new \DateTime(
            $date,
            new \DateTimeZone('UTC')
        );
    }
}