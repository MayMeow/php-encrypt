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
 * @file KeyPairInterface.php
 */

namespace MayMeow\Model;

interface KeyPairInterface
{
    /**
     * Returns private key
     * @return mixed
     */
    public function getPrivateKey();

    /**
     * Set private key
     * @param $privKey
     * @return mixed
     */
    public function setPrivateKey($privKey);

    /**
     * Returns public key
     * @return mixed
     */
    public function getPublicKey();

    /**
     * Set public key
     * @param $privKey
     * @return mixed
     */
    public function setPublicKey($pubKey);
}