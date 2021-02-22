<?php

namespace MayMeow\Cryptography\Filesystem;

use MayMeow\Cryptography\RSA\RSAParameters;
use MayMeow\Cryptography\RSA\RSAParametersInterface;
use MayMeow\Cryptography\RSA\RsaParametersLoaderInterface;

/**
 * Class RsaParametersFileLoader
 *
 * Returns RSA parameters from certificate files cert.crt, key.pem and code.txt if it is provided with encrypted key
 *
 * @package MayMeow\Cryptography\Filesystem
 */
class RsaParametersFileLoader implements FileLoaderInterface, RsaParametersLoaderInterface
{
    private string $certificateStoragePath;

    private RSAParameters $rsaParameters;

    /**
     * RsaParametersFileLoader constructor.
     * @param string|null $certificateStoragePath
     */
    public function __construct(?string $certificateStoragePath = null)
    {
        if ($certificateStoragePath == null) {
            $this->certificateStoragePath = WWW_ROOT;
        } else {
            $this->certificateStoragePath = $certificateStoragePath;
        }
    }

    /**
     * @param string $name
     * @return RSAParametersInterface
     */
    public function load(string $name = null): RSAParametersInterface
    {
        $this->rsaParameters = $this->_initialize($name);

        return $this->rsaParameters;
    }

    /**
     * @param string $name
     * @return RSAParameters
     */
    private function _initialize(string $name): RSAParameters
    {
        // Load public key
        $pub = file_get_contents($this->certificateStoragePath . $name . DS . 'cert.crt');

        // Load Private key
        $priv = file_get_contents($this->certificateStoragePath . $name . DS . 'key.pem');

        // Load passPhrase if exists
        $passPhrase = null;
        $passPhrasePath = $this->certificateStoragePath . $name . DS . 'code.txt';
        if (file_exists($passPhrasePath)) {
            $passPhrase = file_get_contents($passPhrasePath);
        }

        return new RSAParameters($priv, $pub, $passPhrase);
    }
}