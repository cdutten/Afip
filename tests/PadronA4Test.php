<?php
namespace Afip\tests;

use Afip\Authenticator;
use Afip\Dummy;
use Afip\ServiceCaller;
use Afip\WSAAClient;
use PHPUnit\Framework\TestCase;

final class ServiceCallerTest extends TestCase
{
    public function testServiceCaller()
    {
        $wsaaClient = new WSAAClient('ws_sr_padron_a4', __DIR__ . '/../secret/ws_sr_padron_a4/');
        $auth = new Authenticator(__DIR__ . '/../secret/ws_sr_padron_a4/', $wsaaClient);
        $service = new ServiceCaller("https://awshomo.afip.gov.ar/sr-padron/webservices/personaServiceA4?WSDL", $auth);
        $result = $service->Dummy();

        $this->assertObjectHasAttribute("return", $result);
        $this->assertSame(
            'OK',
            $result->return->appserver
        );
        $this->assertSame(
            'OK',
            $result->return->authserver
        );
        $this->assertSame(
            'OK',
            $result->return->dbserver
        );
    }
}