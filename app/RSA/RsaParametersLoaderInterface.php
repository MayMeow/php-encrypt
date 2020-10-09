<?php

namespace MayMeow\Cryptography\RSA;

interface RsaParametersLoaderInterface
{
    /**
     * Load RSAParameters
     * 
     * @param string $name
     * @return RSAParametersInterface
     */
    public function load(string $name) : RSAParametersInterface;
}