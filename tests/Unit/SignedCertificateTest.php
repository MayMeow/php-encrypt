<?php

namespace MayMeow\Tests\Unit;

use MayMeow\Cert\X509Certificate2;
use MayMeow\Model\DomainName;
use MayMeow\Tests\TestCase;
use MayMeow\Model\SignedCertificate;

class SignedCertificateTest extends TestCase
{
    /** @test */
    public function it_is_correct_class()
    {
        $sigCert = new X509Certificate2(new DomainName(), []);

        $this->assertInstanceOf(X509Certificate2::class, $sigCert);
    }
}