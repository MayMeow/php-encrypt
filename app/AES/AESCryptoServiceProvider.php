<?php

namespace MayMeow\Cryptography\AES;

class AESCryptoServiceProvider
{
    const CIPHER_TYPE_GCM = 'aes-256-gcm';
    const DEFAULT_GCM_TAG_LENGTH = 16;

    protected $cipher;

    protected $iv;

    protected $key;

    protected $aad = "127.0.0.1";

    protected $tag;

    public function __construct($cipher = null)
    {
        if ($cipher == null) {
            $this->cipher = static::CIPHER_TYPE_GCM;
        } else {
            $this->cipher = $cipher;
        }
    }

    /**
     * @param $iv
     * @return AESCryptoServiceProvider
     */
    public function setIV($iv): AESCryptoServiceProvider
    {
        $this->iv = $iv;

        return $this;
    }

    /**
     * @param $key
     * @return AESCryptoServiceProvider
     */
    public function setKey($key): AESCryptoServiceProvider
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return bool|string
     */
    public function generateKey()
    {
        if (in_array($this->cipher, openssl_get_cipher_methods())) {
            $this->key = openssl_random_pseudo_bytes(32);

            return $this->key;
        }

        return false;
    }

    /**
     * @return bool|string
     */
    public function generateIV()
    {
        if (in_array($this->cipher, openssl_get_cipher_methods())) {
            $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));

            return $this->iv;
        }

        return false;
    }

    /**
     * Returns encrypted text
     *
     * @param string $plainText
     * @return string
     */
    public function encrypt(string $plainText): string
    {
        $encryptedBytes = openssl_encrypt($plainText, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv, $this->tag, $this->aad);

        return base64_encode($this->iv . $this->tag . $encryptedBytes);
    }

    /**
     * Returns decrypted text
     * @param string $encryptedData
     * @return string
     */
    public function decrypt(string $encryptedData): string
    {
        $c = base64_decode($encryptedData);

        $iv_len = openssl_cipher_iv_length($this->cipher);
        $this->iv = substr($c, 0, $iv_len);
        $this->tag = substr($c, $iv_len, static::DEFAULT_GCM_TAG_LENGTH);
        $encryptedBytes = substr($c, $iv_len + static::DEFAULT_GCM_TAG_LENGTH);

        return openssl_decrypt($encryptedBytes, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv, $this->tag, $this->aad);
    }
}