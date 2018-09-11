<?php

namespace Afip;

use SimpleXMLElement;
use SoapClient;

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

    public function __construct(
        $service,
        $path,
        $url = 'https://wsaahomo.afip.gov.ar/ws/services/LoginCms?wsdl',
        $passphrare = 'xxxxx',
        $proxyHost = '10.20.152.112',
        $proxyPort = '80')
    {

        $this->service = $service;
        $this->path = $path;
        $this->cert = $path . '/' . $service . '.crt';
        $this->privatekey = $path . '/' . $service . '.key';
        $this->passphrare = $passphrare;
        $this->proxyHost = $proxyHost;
        $this->proxyPort = $proxyPort;
        $this->url = $url;
    }

    public function getService()
    {
        return $this->service;
    }

    public function generateTA()
    {
        $this->createTRA();
        $this->signTRA();
        $this->callWSAA();

        return $this;
    }

    private function createTRA()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><loginTicketRequest version="1.0"></loginTicketRequest>';
        $tra = new SimpleXMLElement($xml);
        $tra->addChild('header');
        $tra->header->addChild('uniqueId', date('U'));
        $tra->header->addChild('generationTime', date('c', date('U') - 60));
        $tra->header->addChild('expirationTime', date('c', date('U') + 60));
        $tra->addChild('service', $this->service);
        $tra->asXML($this->path . '/' . $this->service . '_TRA.xml');

        return $this;
    }

    private function signTRA()
    {

        $status = openssl_pkcs7_sign(
            $this->path . '/' . $this->service . '_TRA.xml',
            $this->path . '/' . $this->service . '_TRA.tmp',
            "file://" . $this->cert,
            array("file://" . $this->privatekey, $this->passphrare),
            array(),
            !PKCS7_DETACHED
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
        printf("Se genero el CMS\n");
        $this->cms = $CMS;
        return $this;
    }

    private function callWSAA()
    {
        try {
            $client = new SoapClient(
                './wsaa.wsdl',
                ['proxy_port' => $this->proxyPort,
                    'soap_version' => SOAP_1_2,
                    'location' => $this->url,
                    'trace' => 1,
                    'exceptions' => 1]
            );
            $results = $client->loginCms(array('in0' => $this->cms));
            file_put_contents($this->path . '/' . $this->service . "_request-loginCms.xml", $client->__getLastRequest());
            file_put_contents($this->path . '/' . $this->service . "_response-loginCms.xml", $client->__getLastResponse());
            if (is_soap_fault($results)) {
                throw new Exception("SOAP Fault: " . $results->faultcode . ', ' . $results->faultstring);
            }

            file_put_contents($this->path . '/' . $this->service . "_TA.xml", $results->loginCmsReturn);

        } catch (\Exception $e) {
            throw new Exception('SoapClient Exception: ' . $e->getMessage());
        }

        return $this;
    }


}