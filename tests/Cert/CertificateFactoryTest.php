<?php


namespace MayMeow\Tests\Cert;

use MayMeow\Cryptography\Authority\CertificateAuthority;
use MayMeow\Cryptography\Cert\CertParameters;
use MayMeow\Cryptography\Cert\X509Certificate2;
use MayMeow\Cryptography\Cert\X509CertificateFileWriter;
use MayMeow\Cryptography\RSA\CertificateFileLoader;
use MayMeow\Tests\TestCase;

class CertificateFactoryTest extends TestCase
{
    protected $decyptionKey;

    protected string $caName = "EmmaX Root CA";


    /** @test */
    public function self_signed_ca_certificate_test()
    {
        // Add certificate informations
        $csr = new CertParameters();
        $csr->setCommonName($this->caName);
        $csr->setEmailAddress('test@test.ltd');
        $csr->setOrganizationName('The MayMeow .Ltd');

        $ca = new CertificateAuthority();

        $certificate = $ca->createSelfSigned($csr, \MayMeow\Cryptography\Cert\X509Certificate2::TYPE_CA, 7000);

        // write to file
        $writer = new X509CertificateFileWriter($certificate->getCertParameters()->getCommonName());
        $writer->write($certificate, false, true);

        $this->decyptionKey = $certificate->getEncryptionPass();

        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'cert.crt'));
        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'cert.pfx'));
        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'key.pem'));
        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'pass.txt'));
    }

    /** @test */
    public function user_cert_signing_with_ca_test()
    {
        // Load RSA parameters and Certificate from disk
        $caCert = new CertificateFileLoader($this->caName, $this->decyptionKey);
        $caParams = $caCert->load();

        $csr = new CertParameters();
        $csr->setCommonName('Emma Meow');
        $csr->setEmailAddress('emma@themaymeow.com');
        $csr->setOrganizationName('The MayMeow .Ltd');

        $ca = new CertificateAuthority();

        $certificate = $ca->sign($csr, $caParams, X509Certificate2::TYPE_USER);

        $writer = new X509CertificateFileWriter($certificate->getCertParameters()->getCommonName());
        $writer->write($certificate, false, true);

        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'cert.crt'));
        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'cert.pfx'));
        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'key.pem'));
        $this->assertTrue(file_exists(WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS . 'pass.txt'));
    }
}