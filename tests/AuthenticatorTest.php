<?php

namespace Afip\tests;

use Afip\Authenticator;
use Afip\WSAAClient;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{

    public function testGetCredentials()
    {
        $wsaaClient = new WSAAClient('ws_sr_padron_a4', '../storage/keys/');
        $auth = new Authenticator('../storage/keys/', $wsaaClient);
        $credentials = $auth->getCredentials();
        $this->assertArrayHasKey('token', $credentials);
        $this->assertArrayHasKey('sign', $credentials);
        $this->assertArrayHasKey('cuitRepresentada', $credentials);
        $this->assertSame(11, strlen($credentials['cuitRepresentada']));
    }
}
