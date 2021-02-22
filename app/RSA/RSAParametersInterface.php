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
     * @return bool
     */
    public function isPrivateKeyEncrypted() : bool;

    /**
     * Decrypt private key
     * @return mixed
     */
    public function decryptPrivateKey();

    public function getPassphrase();

    public function getCertifcate();
}