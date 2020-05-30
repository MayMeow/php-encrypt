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

    public function setIV($iv)
    {
        $this->iv = $iv;

        return $this;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;


    }

    public function generateKey()
    {
        if (in_array($this->cipher, openssl_get_cipher_methods())) {
            $this->key = openssl_random_pseudo_bytes(32);

            return $this->key;
        }

        return false;
    }

    public function generateIV()
    {
        if (in_array($this->cipher, openssl_get_cipher_methods())) {
            $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));

            return $this->iv;
        }

        return false;
    }

    public function encrypt($plainText)
    {
        $encryptedBytes = openssl_encrypt($plainText, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv, $this->tag, $this->aad);

        return base64_encode($this->iv . $this->tag . $encryptedBytes);
    }

    public function decrypt($encryptedData)
    {
        $c = base64_decode($encryptedData);

        $iv_len = openssl_cipher_iv_length($this->cipher);
        $this->iv = substr($c, 0, $iv_len);
        $this->tag = substr($c, $iv_len, static::DEFAULT_GCM_TAG_LENGTH);
        $encryptedBytes = substr($c, $iv_len + static::DEFAULT_GCM_TAG_LENGTH);

        $originalText =  openssl_decrypt($encryptedBytes, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv, $this->tag, $this->aad);

        return $originalText;
    }
}