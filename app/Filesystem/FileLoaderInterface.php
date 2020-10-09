<?php

namespace MayMeow\Cryptography\Filesystem;

use MayMeow\Cryptography\RSA\RSAParametersInterface;

interface FileLoaderInterface
{
    public function load(string $name) : RSAParametersInterface;
}