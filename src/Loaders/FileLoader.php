<?php

namespace MayMeow\Loaders;

use MayMeow\Model\KeyPair;
use MayMeow\Model\KeyPairInterface;

/**
 * Class FileLoader
 * @package MayMeow\Loaders
 */
class FileLoader implements KeyPairInterface
{
    protected $keyPair;

    private $passPhrase;

    /**
     * FileLoader constructor.
     *
     * Load certificate from file
     * @param $certificateName
     * @param null $caDataRoot
     */
    public function __construct($certificateName, $caDataRoot = null)
    {
        // Check if is set Ca data root, if not use default one
        if ($caDataRoot == null) $caDataRoot = WWW_ROOT;
        $this->keyPair = KeyPair::initialize();

        // Set public key
        $this->keyPair->setPublicKey(
            file_get_contents($caDataRoot . $certificateName . DS . 'cert.crt')
        );

        // path to file with passphrase to certificate key
        // check if exists and set pass phrase
        $passPhrasePath = $caDataRoot. $certificateName . DS . 'code.txt';
        if (file_exists($passPhrasePath)) {
            $this->passPhrase = file_get_contents($passPhrasePath);
        }

        // set private key based on passphrase existence
        if ($this->passPhrase !== null) {
            $this->keyPair->setPrivateKey([
                file_get_contents($caDataRoot . $certificateName . DS . 'key.pem'),
                $this->passPhrase
            ]);
        } else {
            $this->keyPair->setPrivateKey(file_get_contents($caDataRoot . $certificateName . DS . 'key.pem'));
        }
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