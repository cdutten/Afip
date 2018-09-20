<?php

namespace Afip\tests;

use Afip\Authenticator;
use Afip\WSAAClient;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    /**
     * @throws \Afip\Exception
     */
    public function testGetCredentials()
    {
        $wsaaClient = new WSAAClient('ws_sr_padron_a4', __DIR__ . '/../secret/ws_sr_padron_a4/');
        $auth = new Authenticator(__DIR__ . '/../secret/ws_sr_padron_a4/', $wsaaClient);
        $credentials = $auth->getCredentials();
        $this->assertArrayHasKey('token', $credentials);
        $this->assertArrayHasKey('sign', $credentials);
        $this->assertArrayHasKey('cuitRepresentada', $credentials);
        $this->assertSame(11, strlen($credentials['cuitRepresentada']));
    }
}
