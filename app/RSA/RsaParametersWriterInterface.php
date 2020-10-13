<?php

namespace MayMeow\Cryptography\RSA;

interface RsaParametersWriterInterface
{
    /**
     * @param RSAParameters $RSAParameters
     */
    public function write(RSAParameters $RSAParameters) : void;
}