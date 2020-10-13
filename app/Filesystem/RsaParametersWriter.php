<?php

namespace MayMeow\Cryptography\Filesystem;

use MayMeow\Cryptography\RSA\RSAParameters;
use MayMeow\Cryptography\RSA\RsaParametersWriterInterface;

class RsaParametersWriter implements RsaParametersWriterInterface
{

    /**
     * @inheritDoc
     */
    public function write(RSAParameters $RSAParameters): void
    {
        // TODO: Implement write() method.
    }
}