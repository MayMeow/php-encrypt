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
 * @file SignedCertificate.php
 */

namespace MayMeow\Model;

class SignedCertificate
{
    protected $csr;

    protected $privateKey;

    protected $signedCert;

    protected $encryptionPass;

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        if (null == $this->privateKey) return null;

        return $this->privateKey->getPrivateKey();
    }

    /**
     * @param mixed $privateKey
     * @return SignedCertificate
     */
    public function setPrivateKey($privateKey)
    {
        if (null == $this->privateKey) {
            $this->privateKey = new KeyPair();
        }
        
        $this->privateKey->setPrivateKey($privateKey);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignedCert()
    {
        return $this->signedCert;
    }

    /**
     * @param mixed $signedCert
     * @return SignedCertificate
     */
    public function setSignedCert($signedCert)
    {
        $this->signedCert = $signedCert;
        return $this;
    }

    /**
     * @return int
     */
    public function getEncryptionPass()
    {
        return $this->encryptionPass;
    }

    /**
     * @param int $encryptionPass
     * @return SignedCertificate
     */
    public function setEncryptionPass($encryptionPass)
    {
        $this->encryptionPass = $encryptionPass;
        return $this;
    }

    public function __construct()
    {
        $this->encryptionPass = rand(100000, 999999);
    }

    public function getCsr()
    {
        openssl_csr_export($this->csr, $response);

        return $response;
    }

    public function setCsr($csr)
    {
        $this->csr = $csr;
        return $this;
    }
}