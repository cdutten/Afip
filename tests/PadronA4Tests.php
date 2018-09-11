<?php
namespace Afip\tests;

use Afip\Dummy;
use Afip\ServiceCaller;
use PHPUnit\Framework\TestCase;

final class ServiceCallerTests extends TestCase
{
    public function testServiceCaller()
    {
        $service = new ServiceCaller("https://awshomo.afip.gov.ar/sr-padron/webservices/personaServiceA4?WSDL");
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