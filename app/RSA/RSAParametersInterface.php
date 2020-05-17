<?php

namespace MayMeow\Cryptography\RSA;


interface RSAParametersInterface
{
    /**
     * Get private key
     * @return mixed
     */
    public function getPrivateKey();

    /**
     * Get public key
     * @return mixed
     */
    public function getPublicKey();

    /**
     * Check if private key is encrypted
     * @return mixed
     */
    public function isPrivateKeyEncrypted();

    /**
     * Decrypt private key
     * @return mixed
     */
    public function decryptPrivateKey();
}