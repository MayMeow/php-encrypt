<?php

namespace MayMeow\Cryptography\RSA;

interface RsaParametersLoaderInterface
{
    /**
     * Load RSA parameters
     *
     * @param string|null $name
     * @return RSAParametersInterface
     */
    public function load(string $name = null) : RSAParametersInterface;
}