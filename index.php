<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 12/08/18
 * Time: 21:45
 */

require __DIR__ . '/vendor/autoload.php';

use Afip\Dummy;
use Afip\padronA4;

$service="https://awshomo.afip.gov.ar/sr-padron/webservices/personaServiceA4?WSDL"; //url del servicio
$params=array(); //parametros de la llamada

print_r(padronA4::getPerson($service, $params));
