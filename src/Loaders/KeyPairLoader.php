<?php
/**
 * This file is part of MayMeow/encrypt project
 * Copyright (c) 2017 Charlotta Jung
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 * @copyright Copyright (c) Charlotta MayMeow Jung
 * @link      http://maymeow.click
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @project may-encrypt
 * @file KeyPairFileLoader.php
 */

namespace MayMeow\Loaders;

use MayMeow\Model\KeyPairInterface;
use MayMeow\Factory\CertificateFactory;

/**
 * Class KeyPairLoader
 * @deprecated
 * @package MayMeow\Loaders
 */
class KeyPairLoader implements KeyPairLoaderInterface
{
    /**
     * @var $keyPair
     */
    protected $keyPair;

    /**
     * @var CertificateFactory $certificateFactory
     */
    protected $certificateFactory;

    /**
     * @var bool|string $publicKey
     */
    protected $publicKey;

    /**
     * @var bool|resource $privateKey
     */
    protected $privateKey;

    protected $passphrase;

    /**
     * KeyPairFileLoader constructor.
     * @param $path
     * @param null $passphrase
     */
    public function __construct(CertificateFactory $certificateFactory, KeyPairInterface $keys, $passphrase = null)
    {
        $this->certificateFactory = $certificateFactory;

        $this->passphrase = $passphrase;

        $this->publicKey = $keys->getPublicKey();
        $this->privateKey = $this->_parsePrivateKeyFromInfo($keys->getPrivateKey());

    }

    /**
     * Parse information about private key from given string
     *
     * @param $privKeyInfo
     * @return false|resource
     */
    protected function _parsePrivateKeyFromInfo($privKeyInfo)
    {
        if (null != $this->passphrase) {
            return openssl_pkey_get_private($privKeyInfo, $this->passphrase);
        }

        return $privKeyInfo;
    }

    /**
     * Returns private key
     * @return bool|resource
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Returns public key
     * @return bool|string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}