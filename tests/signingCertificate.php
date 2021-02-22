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

        // Create RSAParameters from generated certificate
        $loader = new \MayMeow\Cryptography\RSA\CertificateLoader($cert);
        $params = $loader->load();

        // Write Certificaate to file
        openssl_x509_export_to_file($params->getPublicKey(), $path . 'cert.crt');

        // Write primary key to file
        openssl_pkey_export_to_file($params->getPrivateKey(),
            $path . 'key.pem', $params->getPassphrase(), $cArgs->getArgs('user'));

        // Write PCKS12
        openssl_pkcs12_export_to_file($params->getPublicKey(),
            $path . 'cert.pfx', $params->getPrivateKey(), $params->getPassphrase(),
            $cArgs->getArgs('user'));
    }

    public function testWighCA()
    {
        // Add certificate informations
        $csr = new \MayMeow\Cryptography\Cert\CertParameters();
        $csr->setCommonName('EmmaX Root CA');
        $csr->setEmailAddress('emma@themaymeow.com');
        $csr->setOrganizationName('The MayMeow .Ltd');

        $ca = new \MayMeow\Cryptography\Authority\CertificateAuthority();

        $certificate = $ca->createSelfSigned($csr, \MayMeow\Cryptography\Cert\X509Certificate2::TYPE_CA, 7000);

        // Create RSAParameters from generated certificate
        $loader = new \MayMeow\Cryptography\RSA\CertificateLoader($certificate);
        $params = $loader->load();

        // write to file
        $writer = new \MayMeow\Cryptography\Cert\X509CertificateFileWriter($certificate->getCertParameters()->getCommonName());
        $writer->write($certificate, false, true);
    }

    public function getDefaultConfiguration(): \MayMeow\Cryptography\Authority\CertificateAuthorityConfigurationInterface
    {
        return $this->conf;
    }

    public function creteUserCert()
    {
        // Load RSA parameters and Certificate from disk
        $caCert = new \MayMeow\Cryptography\RSA\CertificateFileLoader('EmmaX Root CA', '788189');
        $caParams = $caCert->load();

        $csr = new \MayMeow\Cryptography\Cert\CertParameters();
        $csr->setCommonName('Emma Meow');
        $csr->setEmailAddress('emma@themaymeow.com');
        $csr->setOrganizationName('The MayMeow .Ltd');

        $ca = new \MayMeow\Cryptography\Authority\CertificateAuthority();

        $certificate = $ca->sign($csr, $caParams, \MayMeow\Cryptography\Cert\X509Certificate2::TYPE_USER);

        // Create RSAParameters from generated certificate
        /*
         * TODO do not create RSA parameters from certificate because
         *
         * Certificate has X509 certificate and private key
         * RSAParameters are Public and Private key
         *
         * So there will be problem with loading because you need load certificate not only public key if you want sing user certificates.
         *
         * SO use CeritficateLoader and CertificateWriter.
         */

        $writer = new \MayMeow\Cryptography\Cert\X509CertificateFileWriter($certificate->getCertParameters()->getCommonName());
        $writer->write($certificate, false, true);
    }
}

$t = new TestCA();

// $t->testWighCA();
// $t->testWighCA();
$t->creteUserCert();