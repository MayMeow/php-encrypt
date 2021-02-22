<?php

namespace MayMeow\Cryptography\RSA;

use MayMeow\Cryptography\Cert\X509Certificate2;

/**
 * Class CertificateLoader
 *
 * Load RSA parameters from generated certificate in memory
 *
 * @package MayMeow\Cryptography\RSA
 */
class CertificateLoader implements RsaParametersLoaderInterface
{
    protected X509Certificate2 $certificate;

    public function __construct(X509Certificate2 $certificate)
    {
        $this->certificate = $certificate;
    }

    public function load(string $name = null): RSAParametersInterface
    {
        $cert = $this->certificate->getSignedCert();
        $key = $this->certificate->getPrivateKey();
        $pass = $this->certificate->getEncryptionPass();


        return new RSAParameters($key,$cert, $pass);
    }
}