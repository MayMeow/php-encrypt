<?php

namespace MayMeow\Tests\Unit;

use MayMeow\Tests\TestCase;
use MayMeow\Model\SignedCertificate;

class SignedCertificateTest extends TestCase
{
    /** @test */
    public function it_is_correct_class()
    {
        $sigCert = new SignedCertificate();

        $this->assertInstanceOf(SignedCertificate::class, $sigCert);
    }
}