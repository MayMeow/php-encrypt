<?php

use MayMeow\Factory\CertificateFactory;
use MayMeow\Model\EncryptConfiguration;


include_once '../vendor/autoload.php';

include_once '../config/app.php';

/*$ca = new CertificateFactory(new EncryptConfiguration());

$ca->domainName()
    ->setCommonName('Hogwarts root CA')
    ->setCountryName('SK')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry');

$ca->setType('ca')->setName('hogwarts-root-ca')->sign()->toFile();*/


/*$ica = new CertificateFactory(new EncryptConfiguration());

$ica->domainName()
    ->setCommonName('Hogwarts Intermediate CA')
    ->setCountryName('SK')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry');

$ica->setType('intermediate')
    ->setName('hogwarts-intermediate-ca')
    ->setCa('hogwarts-root-ca', 151074)
    ->sign()->toFile();*/

/*$csc = new CertificateFactory(new EncryptConfiguration());

$csc->domainName()
    ->setCommonName('Martin Kukolos')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setOrganizationalUnitName('Hogwarts Students');

$csc->setType('code_sign')
    ->setName('Hogwarts/Students/martin-kukolos')
    ->setCa('hogwarts-intermediate-ca', '776743')
    ->sign()->toFile(['pcks12' => true]);*/





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

    public function getDefaultConfiguration(): \MayMeow\Cryptography\Authority\CertificateAuthorityConfigurationInterface
    {
        return $this->conf;
    }
}

$t = new TestCA();

$t->test();