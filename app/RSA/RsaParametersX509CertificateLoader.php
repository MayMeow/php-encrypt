<?php

namespace MayMeow\Cryptography\RSA;

use MayMeow\Cryptography\Cert\X509Certificate2;

class RsaParametersX509CertificateLoader implements RsaParametersLoaderInterface
{
    protected X509Certificate2 $certificate;

    public function __construct(X509Certificate2 $certificate)
    {
        $this->certificate = $certificate;
    }

    public function load(): RSAParametersInterface
    {
        $cert = $this->certificate->getSignedCert();
        $key = $this->certificate->getPrivateKey();
        $pass = $this->certificate->getEncryptionPass();


        return new RSAParameters($key,$cert, $pass);
        // TODO: Implement load() method.
    }
}