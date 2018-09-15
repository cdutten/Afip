<?php

namespace Afip;

use SimpleXMLElement;
use SoapClient;

/**
 * Class WSAAClient
 * @package Afip
 */
class WSAAClient
{
    /** @var string */
    private $service;
    /** @var string */
    private $cert;
    /** @var string */
    private $privatekey;
    /** @var string */
    private $path;
    /** @var string */
    private $passphrare;
    /** @var string */
    private $proxyHost;
    /** @var string */
    private $proxyPort;
    /** @var string */
    private $url;
    /** @var string */
    private $cms;

    /**
     * WSAAClient constructor.
     * @param $service
     * @param $path
     * @param string $url
     * @param string $passphrare
     * @param string $proxyHost
     * @param string $proxyPort
     * @throws Exception
     */
    public function __construct(
        $service,
        $path,
        $url = 'https://wsaahomo.afip.gov.ar',
        $passphrare = 'xxxxx',
        $proxyHost = '10.20.152.112',
        $proxyPort = '80')
    {

        if (!is_dir($path)) {
            throw new Exception('El path no se encuentra, utilice path absoluto, path: ' . $path);
        }

        $crt = $path . '/' . $service . '.crt';
        $key = $path . '/' . $service . '.key';

        if (!is_file($path . '/' . $service . '.crt')) {
            throw new Exception('El archivo certificado no se encuentra, utilice path absoluto, path: ' . $crt);
        }

        if (!is_file($path . '/' . $service . '.key')) {
            throw new Exception('El archivo key no se encuentra, utilice path absoluto, path: ' . $key);
        }

        $this->service = $service;
        $this->path = $path;
        $this->cert = $crt;
        $this->privatekey = $key;
        $this->passphrare = $passphrare;
        $this->proxyHost = $proxyHost;
        $this->proxyPort = $proxyPort;
        $this->url = $url . '/ws/services/LoginCms?wsdl';
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function generateTA()
    {
        $this->createTRA()
            ->signTRA()
            ->callWSAA();

        return $this;
    }

    /**
     * @return $this
     */
    private function createTRA()
    {
        echo PHP_EOL . "createTRA" . PHP_EOL;
        $xml = '<?xml version="1.0" encoding="UTF-8"?><loginTicketRequest version="1.0"></loginTicketRequest>';
        $tra = new SimpleXMLElement($xml);
        $tra->addChild('header');
        $tra->header->addChild('uniqueId', date('U'));
        $tra->header->addChild('generationTime', date('c', date('U') - 60));
        $tra->header->addChild('expirationTime', date('c', date('U') + 60));
        $tra->addChild('service', $this->service);
        $xml = $tra->asXML($this->path . '/' . $this->service . '_TRA.xml');

        return $this;
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    private function signTRA()
    {
        echo "signTRA" . PHP_EOL;
        $status = openssl_pkcs7_sign(
            $this->path . '/' . $this->service . '_TRA.xml',
            $this->path . '/' . $this->service . '_TRA.tmp',
            "file://" . $this->cert,
            array("file://" . $this->privatekey, $this->passphrare),
            array(),
            false
        );
        if (!$status) {
            throw new Exception('ERROR generating PKCS#7 signature');
        }
        $inf = fopen($this->path . '/' . $this->service . '_TRA.tmp', "r");
        $i = 0;
        $CMS = "";
        while (!feof($inf)) {
            $buffer = fgets($inf);
            if ($i++ >= 4) {
                $CMS .= $buffer;
            }
        }
        fclose($inf);
        unlink($this->path . '/' . $this->service . '_TRA.tmp');
        $this->cms = $CMS;
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    private function callWSAA()
    {
        echo "callWSAA" . PHP_EOL;
        try {
            $client = new SoapClient(
                __DIR__ . '/wsaa.wsdl',
                ['proxy_port' => $this->proxyPort,
                    'soap_version' => SOAP_1_2,
                    'location' => $this->url,
                    'trace' => 1,
                    'exceptions' => 1]
            );
            $results = $client->loginCms(array('in0' => $this->cms));
            file_put_contents(
                $this->path . '/' . $this->service . "_request-loginCms.xml",
                $client->__getLastRequest()
            );
            file_put_contents(
                $this->path . '/' . $this->service . "_response-loginCms.xml",
                $client->__getLastResponse()
            );
            file_put_contents(
                $this->path . '/' . $this->service . "_TA.xml",
                $results->loginCmsReturn
            );

        } catch (\Exception $e) {
            throw new Exception('SoapClient Exception: ' . $e->getMessage() . ' exception:' . get_class($e));
        }

        return $this;
    }
}