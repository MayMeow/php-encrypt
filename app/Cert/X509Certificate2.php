<?php

namespace MayMeow\Cryptography\Cert;

use MayMeow\Cryptography\RSA\RSACryptoServiceProvider;
use MayMeow\Cryptography\RSA\RSAParameters;

class X509Certificate2
{
    const TYPE_CA = 'ca';
    const TYPE_USER = 'user';
    const TYPE_SERVER = 'server';
    const TYPE_CODE_SIGN = 'code_sign';
    const TYPE_INTERMEDIATE = 'intermediate';

    protected RSACryptoServiceProvider $rsa;

    /** @var $csr */
    protected $csr;

    protected RSAParameters $privateKey;

    protected $signedCert;

    protected $encryptionPass;

    public function __construct(CertParameters $certParameters = null, array $configArgs = null)
    {
        $this->encryptionPass = rand(100000, 999999);
        $this->privateKey = $this->_getRsa()->generateKeyPair();

        $privKey = $this->privateKey->getPrivateKey();
        $this->csr = openssl_csr_new($certParameters->toArray(), $privKey, $configArgs);
    }

    protected function _getRsa()
    {
        $this->rsa = new RSACryptoServiceProvider();

        return $this->rsa;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey->getPrivateKey();
    }

    /**
     * @return mixed
     */
    public function getSignedCert()
    {
        return $this->signedCert;
    }

    /**
     * @deprecated
     * @param $signedCert
     * @return $this
     */
    public function setSignedCert($signedCert)
    {
        $this->signedCert = $signedCert;
        return $this;
    }

    /**
     * @return int
     */
    public function getEncryptionPass()
    {
        return $this->encryptionPass;
    }

    /**
     * @return mixed
     */
    public function getCsr()
    {
        openssl_csr_export($this->csr, $response);

        return $response;
    }

    /**
     * @param $csr
     * @return $this
     */
    public function setCsr($csr)
    {
        $this->csr = $csr;
        return $this;
    }

    /**
     * Sign certificate with Certification authority
     * @param $daysValid
     * @param $caCertificate
     * @param $caKey
     * @param array|null $certConfiguration
     */
    public function sign($caCertificate, $caKey, $daysValid, array $certConfiguration = null)
    {
        $this->signedCert = openssl_csr_sign(
            $this->csr,
            $caCertificate,
            $caKey,
            $daysValid,
            $certConfiguration,
            time()
        );
    }

    /**
     * Create self-signed certificate
     *
     * @param $daysValid
     * @param array|null $certConfiguration
     */
    public function selfSigned($daysValid, array $certConfiguration = null)
    {
        $this->signedCert = openssl_csr_sign(
            $this->csr,
            null,
            $this->privateKey->getPrivateKey(),
            $daysValid,
            $certConfiguration,
            time()
        );
    }
}