<?php

require_once './src/Afip/WSAAClient.php';
require_once'./src/Afip/Exception.php';
require_once'./src/Afip/AuthenticatorInterface.php';
require_once'./src/Afip/Authenticator.php';
require_once './src/Afip/ServiceCaller.php';

$path = $argv[1];
$cuit = $argv[2];
$service = 'ws_sr_padron_a4';
$url = 'https://wsaahomo.afip.gov.ar/ws/services/LoginCms?wsdl';
$wsd = 'https://awshomo.afip.gov.ar/sr-padron/webservices/personaServiceA4?WSDL';
$passphrare = 'xxxxx';
$host = '10.20.152.112';
$port = '80';
try {
    $wsaa = new \Afip\WSAAClient($service, $path, $url, $passphrare, $host, $port);
    $auth = new \Afip\Authenticator($path, $wsaa);
    $service = new \Afip\ServiceCaller($wsd, $auth);
    var_dump($service->getPersona(['idPersona'=>$cuit]) );
}catch (\Exception $e){
    print_r('Algo fallo: ' . $e->getMessage() . PHP_EOL);
}
echo 'Fin de ejecución';