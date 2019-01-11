<?php

namespace Afip\tests;

use Afip\Validators\DNIValidator;
use PHPUnit\Framework\TestCase;


class DNIValidatorTest extends TestCase
{
    public function testValidateDNI()
    {
         $this->assertTrue(DNIValidator::validateDNI('20179706', 'M'));
    }

    public function testValidateDNIFail()
    {
        $this->assertTrue(DNIValidator::validateDNI('40838435', 'M'));
    }

    public function testCalculatePossibleCuits()
    {
        $this->assertNotEmpty(DNIValidator::calculatePossibleCuits('40838435', [20, 23, 24]));
    }
}