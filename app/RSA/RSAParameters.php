<?php

namespace MayMeow\Cryptography\RSA;

class RSAParameters implements RSAParametersInterface
{
    private $privateKey;

    private $publicKey;

    private $passphrase;

    /**
     * RSAParameters constructor.
     * @param $privateKey
     * @param $publicKey
     * @param null $passphrase
     */
    public function __construct(
        $privateKey,
        $publicKey,
        $passphrase = null
    )
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;

        if ($passphrase != null) {
            $this->passphrase = $passphrase;
        }
    }

    /**
     * @return bool
     */
    public function isPrivateKeyEncrypted() : bool
    {
        if ($this->passphrase != null) {
            return true;
        }

        return false;
    }

    public function decryptPrivateKey()
    {
        if ($this->passphrase != null && $this->privateKey != null) {
            return openssl_pkey_get_private($this->privateKey, $this->passphrase);
        }

        return false;
    }

    /**
     * @return mixed Private key as it is
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }
}