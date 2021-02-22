<?php

namespace MayMeow\Cryptography\Filesystem;

use MayMeow\Cryptography\RSA\RSAParameters;
use MayMeow\Cryptography\RSA\RsaParametersWriterInterface;

class RsaParametersWriter implements RsaParametersWriterInterface
{
    public function construct(string $name, string $path = WWW_ROOT)
    {
        $storagePath = $path . $name . DS;

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }
    }

    /**
     * @inheritDoc
     */
    public function write(RSAParameters $RSAParameters): void
    {
        // TODO: Implement write() method.
    }
}