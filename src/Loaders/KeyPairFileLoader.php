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

class KeyPairFileLoader implements KeyPairLoaderInterface
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

    /**
     * KeyPairFileLoader constructor.
     * @param $path
     * @param null $pass
     */
    public function __construct($path, $pass = null)
    {
        $this->certificateFactory = new CertificateFactory();

        $this->publicKey = $this->certificateFactory->getPublicKey($path);
        $this->privateKey = $this->_parsePrivateKeyFromInfo($this->certificateFactory->getPrivateKey($path, $pass));

    }

    /**
     * Returns private key from given key information
     * @param $privKeyInfo
     * @return bool|resource
     */
    protected function _parsePrivateKeyFromInfo($privKeyInfo)
    {
        if (is_array($privKeyInfo)) return openssl_get_privatekey($privKeyInfo[0], $privKeyInfo[1]);

        return openssl_get_privatekey($privKeyInfo);
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