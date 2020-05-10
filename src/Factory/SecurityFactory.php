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
 * @file SecurityFactory.php
 */

/**
 * Created by PhpStorm.
 * User: martin
 * Date: 4/15/2017
 * Time: 9:32 PM
 */

namespace MayMeow\Factory;

use MayMeow\Loaders\KeyPairLoaderInterface;
use MayMeow\RSA\RSACryptoServiceProvider;

/**
 * Class SecurityFactory
 * @deprecated
 * @see RSACryptoServiceProvider
 * @package MayMeow\Factory
 */
class SecurityFactory
{

    /**
     * @var $privateKey
     */
    protected $privateKey;

    /**
     * @var $publicKey
     */
    protected $publicKey;

    /**
     * @var array $recipientKeys
     */
    protected $recipientKeys = [];

    /**
     * @var $string
     */
    protected $string;

    /**
     * @var CertificateFactory $certificateFactory
     */
    protected $certificateFactory;

    /**
     * SecurityFactory constructor.
     * @param CertificateFactory $certificateFactory
     */
    public function __construct(CertificateFactory $certificateFactory)
    {
        $this->certificateFactory = $certificateFactory;
    }

    /**
     * @return CertificateFactory
     */
    public function getCertificateFactory()
    {
        return $this->certificateFactory;
    }

    /**
     * Returns private key from given key information
     */
    protected function _parsePrivateKeyFromInfo($privKeyInfo)
    {
        if (is_array($privKeyInfo)) return openssl_get_privatekey($privKeyInfo[0], $privKeyInfo[1]);

        return openssl_get_privatekey($privKeyInfo);
    }

    /**
     * @param $path
     * @param $pass
     */
    public function setPrivateKey($path, $pass)
    {
        $privKeyInfo = $this->certificateFactory->getPrivateKey($path,$pass);

        $this->privateKey = $this->_parsePrivateKeyFromInfo($privKeyInfo);
    }

    /**
     * @param $path
     */
    public function setPublicKey($path)
    {
        $pubKey = $this->certificateFactory->getPublicKey($path);

        $this->publicKey = openssl_get_publickey($pubKey);
    }

    /**
     * Set key pair
     * @param KeyPairLoaderInterface $keyPairLoader
     */
    public function setKeyPair(KeyPairLoaderInterface $keyPairLoader)
    {
        $this->privateKey = $keyPairLoader->getPrivateKey();
        $this->publicKey = $keyPairLoader->getPublicKey();
    }

    /**
     * @param $string
     * @return $this
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @param null $path
     * @return $this
     */
    public function addRecipientKey($path = null)
    {
        $this->recipientKeys[] = $this->certificateFactory->getPublicKey($path);

        return $this;
    }

    /**
     * @return string
     */
    public function encrypt()
    {
        $encrypted = '';
        openssl_private_encrypt($this->string, $encrypted, $this->privateKey);

        return $encrypted;
    }

    /**
     * @return string
     */
    public function decrypt()
    {
        $decrypted = '';
        openssl_public_decrypt($this->string, $decrypted, $this->publicKey);

        return $decrypted;
    }

    /**
     * @return string
     */
    public function publicEncrypt()
    {
        $encrypted = '';
        openssl_public_encrypt($this->string, $encrypted, $this->publicKey);

        return $encrypted;
    }

    /**
     * @return string
     */
    public function privateDecrypt()
    {
        $decrypted = '';
        openssl_private_decrypt($this->string, $decrypted, $this->privateKey);

        return $decrypted;
    }

    /**
     * @return array
     */
    public function seal()
    {
        openssl_seal($this->string, $sealed, $envelopeKeys, $this->recipientKeys);

        return [
            'sealed' => $sealed,
            'keys' => $envelopeKeys
        ];
    }

    /**
     * @param $key
     * @return mixed
     */
    public function open($key)
    {
        openssl_open($this->string, $decrypted, $key, $this->privateKey);
        return $decrypted;
    }

    /**
     * @return mixed
     */
    public function sign()
    {
        openssl_sign($this->string, $signature, $this->privateKey);

        return $signature;
    }

    /**
     * @param $signature
     * @return int
     */
    public function verify($signature)
    {
        return openssl_verify($this->string, $signature, $this->publicKey);
    }

    /**
     * @param $pass
     */
    public function decryptPrivateKey($pass)
    {
        // TODO
    }

}