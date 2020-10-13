<?php

namespace MayMeow\Writers;

use MayMeow\Cert\X509Certificate2;
use MayMeow\Interfaces\WriterInterface;

class FileWriter implements WriterInterface
{
    /** @var X509Certificate2 $cert */
    protected $cert;

    /** @var string $name */
    protected $name;

    /** @var array $certConfiguration */
    protected $certConfiguration;

    /**
     * @param \MayMeow\Cert\X509Certificate2|\MayMeow\Cryptography\Cert\X509Certificate2 $cert
     * @return FileWriter
     */
    public function setCert($cert)
    {
        $this->cert = $cert;
        return $this;
    }

    /**
     * @param mixed $name
     * @return FileWriter
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $certConfiguration
     * @return FileWriter
     */
    public function setCertConfiguration($certConfiguration)
    {
        $this->certConfiguration = $certConfiguration;
        return $this;
    }

    /**
     *
     */
    public function write($decryptPK = false, $pcks12 = false)
    {
        file_put_contents($this->name . 'code.txt', $this->cert->getEncryptionPass());
        file_put_contents($this->name . 'req.pem', $this->cert->getCsr());

        openssl_x509_export_to_file($this->cert->getSignedCert(), $this->name . 'cert.crt');
        openssl_pkey_export_to_file($this->cert->getPrivateKey(),
            $this->name . 'key.pem', $this->cert->getEncryptionPass(), $this->certConfiguration);

        if ($decryptPK) {
            openssl_pkey_export_to_file($this->cert->getPrivateKey(),
                $this->name . 'unenc.key.pem', null, $this->certConfiguration);
        }

        if ($pcks12) {
            openssl_pkcs12_export_to_file($this->cert->getSignedCert(),
                $this->name . 'cert.pfx', $this->cert->getPrivateKey(), $this->cert->getEncryptionPass(),
                $this->certConfiguration);
        }

    }
}