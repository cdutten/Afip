<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 09/09/18
 * Time: 16:35
 */

namespace Afip\tests;

use Afip\Authenticator;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class AuthenticatorTest extends TestCase
{

    public function testGetCredentials()
    {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();
        $auth = new Authenticator('../storage/keys/TA.xml');
        $credentials = $auth->getCredentials();
        $this->assertArrayHasKey('token', $credentials);
        $this->assertArrayHasKey('sign', $credentials);
        $this->assertArrayHasKey('cuitRepresentada', $credentials);
        $this->assertSame(11, strlen($credentials['cuitRepresentada']));
    }
}
