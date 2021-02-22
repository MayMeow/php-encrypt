<?php

namespace MayMeow\Cryptography\RSA;

/**
 * Class CertificateFileLoader
 *
 * Load RSAParameters from file
 *
 * @package MayMeow\Cryptography\RSA
 */
class CertificateFileLoader implements RsaParametersLoaderInterface
{
    protected $pk;

    protected $crt;

    protected $pass;

    public function __construct(string $name, $pass = null, $path = WWW_ROOT)
    {
        $pkInfo = file_get_contents(WWW_ROOT . $name . DS . 'key.pem');

        // do not specify password for decryption into RSA parameters because key is already decrypted
        $this->pk = openssl_get_privatekey($pkInfo, $pass);

        $this->rawPublicKey = file_get_contents(WWW_ROOT . $name . DS . 'cert.crt');

        $this->crt = openssl_get_publickey($this->rawPublicKey);

        $this->pass = $pass;
    }

    /**
     * @param string|null $name
     * @return RSAParametersInterface
     */
    public function load(string $name = null): RSAParametersInterface
    {
        return new RSAParameters($this->pk, $this->crt, null, $this->rawPublicKey);
    }
}