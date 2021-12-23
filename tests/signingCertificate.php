<?php

use MayMeow\Factory\CertificateFactory;
use MayMeow\Model\EncryptConfiguration;


include_once '../vendor/autoload.php';

include_once '../config/app.php';


class TestCA implements \MayMeow\Cryptography\Authority\CertificateAuthorityInterface
{
    protected $conf;
    public function testSelfSigned()
    {
        // Add certificate informations
        $csr = new \MayMeow\Cryptography\Cert\CertParameters();
        $csr->setCommonName('Emma');

        // Load certificate template paths config & standard configuration for certificates
        $this->conf = \MayMeow\Cryptography\Authority\DefaultCertificateAuthorityConfiguration::getInstance();

        // Configuration arguments loaded from templates
        $cArgs = \MayMeow\Cryptography\Authority\CertificateConfigArgs::getInstance($this);

        // Intialialize new certificate
        // add to certificate authority sign(CertParameters $csr, string $type, ?AlternativeNames $altNames = null)
        $cert = new \MayMeow\Cryptography\Cert\X509Certificate2($csr, $cArgs->getArgs('user'));

        // Create Self Signed certificate
        $cert->selfSigned(365);

        // this is your signed certificate
        var_dump($cert->getEncryptionPass());

        $path = WWW_ROOT . $csr->getCommonName() . DS;

        if (!file_exists($path)) {
            mkdir($path);
        }

        // Write Certificaate to file
        openssl_x509_export_to_file($cert->getSignedCert(), $path . 'cert.crt');

        // Write primaary key to file
        openssl_pkey_export_to_file($cert->getPrivateKey(),
            $path . 'key.pem', $cert->getEncryptionPass(), $cArgs->getArgs('user'));

        // Write PCKS12
        openssl_pkcs12_export_to_file($cert->getSignedCert(),
            $path . 'cert.pfx', $cert->getPrivateKey(), $cert->getEncryptionPass(),
            $cArgs->getArgs('user'));
    }

    public function testWighCA()
    {
        // Add certificate informations
        $csr = new \MayMeow\Cryptography\Cert\CertParameters();
        $csr->setCommonName('EmmaX');
        $csr->setEmailAddress('emma@themaymeow.com');
        $csr->setOrganizationName('The MayMeow .Ltd');

        $ca = new \MayMeow\Cryptography\Authority\CertificateAuthority();

        $certificate = $ca->createSelfSigned($csr, \MayMeow\Cryptography\Cert\X509Certificate2::TYPE_USER, 7000);

        $path = WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS;

        if (!file_exists($path)) {
            mkdir($path);
        }

        // Write Certificaate to file
        openssl_x509_export_to_file($certificate->getSignedCert(), $path . 'cert.crt');

        // Write primaary key to file
        openssl_pkey_export_to_file($certificate->getPrivateKey(),
            $path . 'key.pem', $certificate->getEncryptionPass(), $certificate->getConfigArgs());

        // Write PCKS12
        openssl_pkcs12_export_to_file($certificate->getSignedCert(),
            $path . 'cert.pfx', $certificate->getPrivateKey(), $certificate->getEncryptionPass(),
            $certificate->getConfigArgs());
    }

    public function getDefaultConfiguration(): \MayMeow\Cryptography\Authority\CertificateAuthorityConfigurationInterface
    {
        return $this->conf;
    }
}

$t = new TestCA();

$t->testWighCA();
