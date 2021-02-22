<?php

namespace MayMeow\Loaders;

use MayMeow\Cryptography\Filesystem\RsaParametersFileLoader;
use MayMeow\Model\KeyPair;
use MayMeow\Model\KeyPairInterface;

/**
 * Class CertificateFileLoader
 * @package MayMeow\Loaders
 * @deprecated
 * @see \MayMeow\Cryptography\Filesystem\RsaParametersFileLoader
 */
class FileLoader implements KeyPairInterface
{
    protected $keyPair;

    /**
     * CertificateFileLoader constructor.
     *
     * Load certificate from file
     * @param $certificateName
     * @param null $caDataRoot
     */
    public function __construct($certificateName, $caDataRoot = null)
    {
        $fileLoader = new RsaParametersFileLoader($caDataRoot);

        $this->keyPair = $fileLoader->load($certificateName);
    }

    /**
     * @inheritDoc
     */
    public function getPrivateKey()
    {
        return $this->keyPair->getPrivateKey();
    }

    /**
     * @inheritDoc
     */
    public function setPrivateKey($privKey)
    {
        // TODO: Implement setPrivateKey() method.
    }

    /**
     * @inheritDoc
     */
    public function getPublicKey()
    {
        return $this->keyPair->getPublicKey();
    }

    /**
     * @inheritDoc
     */
    public function setPublicKey($pubKey)
    {
        // TODO: Implement setPublicKey() method.
    }
}