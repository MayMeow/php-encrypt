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
 * @file KeyPair.php
 */

namespace MayMeow\Model;

class KeyPair implements KeyPairInterface
{
    protected $privateKey;

    protected $publicKey;

    /**
     * @return KeyPair
     */
    public static function initialize()
    {
        return new self();
    }

    private function __construct()
    {
    }

    /**
     * Returns private key
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Set private key
     * @param $privKey
     * @return $this
     */
    public function setPrivateKey($privKey)
    {
        $this->privateKey = $privKey;

        return $this;
    }

    /**
     * Returns public key
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set public key
     * @param $pubKey
     * @return $this
     */
    public function setPublicKey($pubKey)
    {
        $this->publicKey = $pubKey;

        return $this;
    }
}