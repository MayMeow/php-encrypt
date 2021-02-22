<?php

namespace MayMeow\Cryptography\Cert;

use MayMeow\Cryptography\RSA\RSACryptoServiceProvider;
use MayMeow\Cryptography\RSA\RSAParameters;

/**
 * Class X509Certificate2
 * @package MayMeow\Cryptography\Cert
 */
class X509Certificate2 implements X509Certificate2Interface
{
    const TYPE_CA = 'ca';
    const TYPE_USER = 'user';
    const TYPE_SERVER = 'server';
    const TYPE_CODE_SIGN = 'code_sign';
    const TYPE_INTERMEDIATE = 'intermediate';

    protected RSACryptoServiceProvider $rsa;

    /** @var $csr */
    protected $csr;

    protected RSAParameters $rsaParameters;

    protected $signedCert;

    protected $encryptionPass;

    protected CertParameters $certParameters;

    /**
     * @var array|null
     */
    protected ?array $configArgs;

    /**
     * X509Certificate2 constructor.
     * @param CertParameters $certParameters
     * @param array|null $configArgs
     */
    public function __construct(CertParameters $certParameters, array $configArgs = null)
    {
        $this->certParameters = $certParameters;
        $this->encryptionPass = rand(100000, 999999);

        $this->rsaParameters = $this->_getRsa()->generateKeyPair();
        $privateKey = $this->rsaParameters->getPrivateKey();
        $this->configArgs = $configArgs;

        $this->csr = openssl_csr_new($certParameters->toArray(), $privateKey, $this->configArgs);
    }

    protected function _getRsa()
    {
        $this->rsa = new RSACryptoServiceProvider();

        return $this->rsa;
    }

    /**
     * Return ConfigArgs for signed certificate
     *
     * @return array|null
     */
    public function getConfigArgs(): ?array
    {
        return $this->configArgs;
    }

    /**
     * Return original certificate parameters from which it was created
     *
     * @return CertParameters
     */
    public function getCertParameters(): CertParameters
    {
        return $this->certParameters;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->rsaParameters->getPrivateKey();
    }

    /**
     * @return mixed
     */
    public function getSignedCert()
    {
        return $this->signedCert;
    }

    /**
     * @param $signedCert
     * @return $this
     * @deprecated
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
     *
     * @param $daysValid
     * @param $caCertificate
     * @param $caKey
     * @param array|null $certConfiguration
     */
    public function sign($caCertificate, $caKey, $daysValid, array $certConfiguration = null)
    {
        if ($certConfiguration == null) {
            $certConfiguration = $this->configArgs;
        }

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
        if ($certConfiguration == null) {
            $certConfiguration = $this->configArgs;
        }

        $this->signedCert = openssl_csr_sign(
            $this->csr,
            null,
            $this->rsaParameters->getPrivateKey(),
            $daysValid,
            $certConfiguration,
            time()
        );
    }
}