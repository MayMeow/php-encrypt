<?php

namespace MayMeow\Cert;

use MayMeow\Model\DomainName;
use MayMeow\Model\KeyPair;
use MayMeow\Model\KeyPairInterface;
use MayMeow\RSA\RSACryptoServiceProvider;

class X509Certificate2
{
    /** @var RSACryptoServiceProvider */
    protected $rsa;

    /** @var $csr */
    protected $csr;

    /** @var KeyPairInterface */
    protected $privateKey;

    protected $signedCert;

    protected $encryptionPass;

    public function __construct(DomainName $dn, array $configArgs)
    {
        $this->encryptionPass = rand(100000, 999999);
        $this->_getRsa();
        $this->privateKey = KeyPair::initialize();
        $this->privateKey->setPrivateKey($this->rsa->generateKeyPair()->getPrivateKey());

        $privKey = $this->privateKey->getPrivateKey();
        $this->csr = openssl_csr_new($dn->get(), $privKey, $configArgs);
    }

    protected function _getRsa()
    {
        if ($this->rsa == null) {
            $this->rsa = new RSACryptoServiceProvider();
        }

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
     * @return X509Certificate2
     */
    public function setPrivateKey($privateKey): X509Certificate2
    {
        $this->privateKey->setPrivateKey($privateKey);
        return $this;
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
     * @param $encryptionPass
     * @return $this
     */
    public function setEncryptionPass($encryptionPass)
    {
        $this->encryptionPass = $encryptionPass;
        return $this;
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