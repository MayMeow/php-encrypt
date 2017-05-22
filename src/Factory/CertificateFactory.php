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
 * @file CertificateFactory.php
 */

namespace MayMeow\Factory;

use MayMeow\Model\AltNames;
use MayMeow\Model\DomainName;
use MayMeow\Model\SignedCertificate;
use Symfony\Component\Yaml\Yaml;

class CertificateFactory implements CertificateFactoryInterface
{
    /**
     * @var DomainName
     */
    protected $domainName;

    /**
     * Alternative names for certificate
     * DNS, IP, URL
     *
     * @var
     */
    protected $altNames;

    /**
     * Loaded config from encrypt.yml
     *
     * @var
     */
    protected $config;

    /**
     * Configuration for certificate based on certificate type
     *
     * @var array
     */
    protected $certConfigure = [];

    /**
     * Certification Authority name
     *
     * @var string caName
     */
    protected $caName;

    /**
     * Password for CA's private key
     *
     * @var string caPassword
     */
    protected $caPassword;

    /**
     * Name for certificate files
     *
     * @var
     */
    protected $fileName;

    /**
     * Type of certificate
     * User, server, ca or intermediate
     *
     * @var
     */
    protected $type;

    /**
     * Certificate model
     * Here will be stored all required variables, keys, csr and certificate
     *
     * @var
     */
    protected $crt;

    /**
     * Default template with certificate configurations
     *
     * @var array typeConfigurations
     */
    protected $typeConfigurations = [
        'ca' => TEMPLATE_ROOT . 'ca_certificate.cnf',
        'user' => TEMPLATE_ROOT . 'intermediate_certificate.cnf',
        'server' => TEMPLATE_ROOT . 'intermediate_certificate.cnf',
        'intermediate' => TEMPLATE_ROOT . 'intermediate_certificate.cnf'
    ];

    public function __construct()
    {
        $this->_setConfig();
    }

    /**
     * Load Default Configuration
     */
    protected function _setCertConfigure()
    {
        $this->certConfigure = [
            'config' => $this->typeConfigurations[$this->type],
            'x509_extensions' => $this->_getConfig('x509_extensions'),
            'private_key_bits' => $this->config['default']['private_key_bits']
        ];
    }

    /**
     * Load Default configuration
     */
    protected function _setConfig()
    {
        $cnf = file_get_contents(CONFIG . 'encrypt.yml');
        $this->config = Yaml::parse($cnf);
    }

    /**
     * Return certificates setting
     *
     * @param null $key
     * @return mixed
     */
    protected function _getConfig($key = null)
    {
        return $this->config['certificates'][$this->type][$key];
    }

    /**
     * Load CA Certificate from file
     *
     * @return string
     */
    protected function _getCaCert()
    {
        return file_get_contents(WWW_ROOT . $this->caName . DS .'cert.crt');
    }

    /**
     * Load Ca Private key from file
     *
     * @return array
     */
    protected function _getCaKey()
    {
        return self::getPrivateKey($this->caName, $this->caPassword);
    }

    /**
     * Method _altConfiguration
     *
     * Create alternative configuration based on altNames
     * CNF file will have name based on certificate name - certificate-name.crt -> certificate-name.cnf
     */
    protected function _altConfiguration()
    {
        $cnfFile = file_get_contents($this->certConfigure['config']);
        if ($this->altNames) {
            $cnfFile .= $this->altNames->toString();
            $altFileName = $this->fileName . DS . 'config.cnf';
            $this->certConfigure['config'] = $altFileName;

            file_put_contents($altFileName, $cnfFile);
        }
    }

    /**
     * Sets type of certificate
     *
     * @param $type
     * @param null $options
     * @return $this
     */
    public function setType($type, $options = null)
    {
        $this->type = $type;
        $this->_setCertConfigure();

        return $this;
    }

    /**
     * Function SetCa
     * Functions to set CA name to use for signing certificate
     *
     * @param null $name
     * @param null $password
     * @return $this
     */
    public function setCa($name = null, $password = null)
    {
        $this->caName = $name;
        $this->caPassword = $password;

        return $this;
    }

    /**
     * Function DomainName
     * Returns Domain name
     *
     * @return DomainName
     */
    public function domainName()
    {
        if (!$this->domainName) {
            $this->domainName = new DomainName();
        }

        return $this->domainName;
    }

    /**
     * Method getAltNames
     * returns AltNames
     *
     * @return AltNames
     */
    public function getAltNames()
    {
        if (!$this->altNames) {
            $this->altNames = new AltNames();
        }

        return $this->altNames;
    }

    /**
     * Function getConfig
     * returns loaded configuration
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Function SetName
     * Set name of certificate file
     *
     * @param null $name
     * @return $this
     */
    public function setName($name = null)
    {
        $this->fileName = WWW_ROOT . $name . DS;

        return $this;
    }

    /**
     * Sign certificate file and export tem to disk
     */
    public function sign()
    {
        $this->crt = new SignedCertificate();

        $this->_altConfiguration();

        print_r($this->altNames);

        print_r([
            $this->certConfigure, $this->domainName()->get()
        ]);

        $this->crt->setPrivateKey(openssl_pkey_new($this->certConfigure));


        $privKey = $this->crt->getPrivateKey();
        $this->crt->setCsr(openssl_csr_new($this->domainName()->get(), $privKey, $this->certConfigure));

        if (!$this->caName == null) {
            // If CA name is not null sign certificate with loaded CA certificate
            $this->crt->setSignedCert(openssl_csr_sign(
                $this->crt->getCsr(), $this->_getCaCert(), $this->_getCaKey(), $this->_getConfig('daysvalid'), $this->certConfigure, time()
            ));
        } else {
            /**
             * Else self sign certificate
             * Its important for ROOT Certification authority certificate
             */
            $this->crt->setSignedCert(openssl_csr_sign(
                $this->crt->getCsr(), null, $this->crt->getPrivateKey(), $this->_getConfig('daysvalid'), $this->certConfigure, time()
            ));
        }

        return $this;
    }

    /**
     * Create request for server signing
     * For Client App
     *
     * @return string
     */
    public function createRequest()
    {
        $this->crt = new SignedCertificate();
        $this->crt->setPrivateKey(openssl_pkey_new($this->certConfigure));

        $privKey = $this->crt->getPrivateKey();
        $this->crt->setCsr(openssl_csr_new($this->domainName()->get(), $privKey, $this->certConfigure));

        $request = json_encode([
            'csr' => $this->crt->getCsr()
        ]);

        // Send CSR to server and wait for signing
        $response = $this->signWithServer($request);
        $response = json_decode($response);
        $this->crt->setSignedCert(openssl_x509_read($response->certificate));

        return $this;
    }

    /**
     * Export certificate to file
     *
     * @param null $pkcs12
     */
    public function toFile($pkcs12 = null)
    {
        if(!file_exists($this->fileName))
        {
            mkdir($this->fileName, 0777, true);
        }
        file_put_contents($this->fileName . 'code.txt', $this->crt->getEncryptionPass());

        openssl_x509_export_to_file($this->crt->getSignedCert(), $this->fileName . 'cert.crt');
        openssl_pkey_export_to_file($this->crt->getPrivateKey(), $this->fileName . 'key.pem', $this->crt->getEncryptionPass(), $this->certConfigure);

        if ($pkcs12 !== null) {
            openssl_pkcs12_export_to_file($this->crt->getSignedCert(), $this->fileName . 'cert.pfx', $this->crt->getPrivateKey(), $this->crt->getEncryptionPass(), $this->certConfigure);
        }
    }


    /**
     * Sign certificate from client request
     * For Server app
     *
     * @return $this
     */
    public function signWithServer($request)
    {
        //server
        $clientRequest = json_decode($request);
        $this->crt->setSignedCert(openssl_csr_sign($clientRequest->csr, $this->_getCaCert(), $this->_getCaKey(), $this->_getConfig('daysvalid'), $this->certConfigure, time()));

        // return signed file to user
        openssl_x509_export($this->crt->getSignedCert(), $clientCertificate);

        return json_encode(['certificate' => $clientCertificate]);
    }

    /**
     * Method getCaKey
     *
     * @param $caName
     * @param $caPassword
     * @return array
     */
    public static function getPrivateKey($caName = null, $caPassword = null)
    {
        return [
            file_get_contents(WWW_ROOT . $caName . DS .'key.pem'),
            $caPassword
        ];
    }

    /**
     * Method getPublicKey
     *
     * @param null $caName
     * @return bool|string
     */
    public static function getPublicKey($caName = null)
    {
        return file_get_contents(WWW_ROOT . $caName . DS . 'cert.crt');
    }
}