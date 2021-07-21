<?php

namespace MayMeow\Cryptography\RSA;

/**
 * Class RSAParameters
 * Include parts as private key, public key and passphrase which is used for private key protection
 *
 * @package MayMeow\Cryptography\RSA
 */
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
     * Check if is private key endcypted
     * @deprecated
     *
     * @return bool
     */
    public function isPrivateKeyEncrypted() : bool
    {
        if ($this->passphrase != null) {
            return true;
        }

        return false;
    }

    /**
     * If there is passphrase then private key is encrypted and it will need to be decripted
     * @deprecated Will ne automatically decrypted when you asking for private key
     *
     * @return false|mixed|resource
     */
    public function decryptPrivateKey()
    {
        if ($this->passphrase != null && $this->privateKey != null) {
            return openssl_pkey_get_private($this->privateKey, $this->passphrase);
        }

        return false;
    }

    /**
     * Returns private key
     *
     * @return mixed Private key as it is
     */
    public function getPrivateKey()
    {
        // decrypt it if is encrypted
        if ($this->passphrase != null && $this->privateKey != null) {
            return openssl_pkey_get_private($this->privateKey, $this->passphrase);
        }

        return $this->privateKey;
    }

    /**
     * Returns public key
     *
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}