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
     * Returns private key
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Set private key
     */
    public function setPrivateKey($privKey)
    {
        $this->privateKey = $privKey;

        return $this;
    }

    /**
     * Returns public key
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set public key
     */
    public function setPublicKey($pubKey)
    {
        $this->publicKey = $pubKey;

        return $this;
    }
}