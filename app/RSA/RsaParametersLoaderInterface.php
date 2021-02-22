<?php

namespace MayMeow\Cryptography\RSA;

interface RsaParametersLoaderInterface
{
    /**
     * Load RSAParameters
     *
     * @return RSAParametersInterface
     */
    public function load() : RSAParametersInterface;
}