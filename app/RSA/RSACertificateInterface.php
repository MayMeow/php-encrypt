<?php

namespace MayMeow\Cryptography\RSA;

interface RSACertificateInterface
{
    /**
     * Returns raw data fro certificate loaded from file
     * This is needed when you want to sign user certificate with CA
     *
     * @return mixed
     */
    public function getCertifcate();
}