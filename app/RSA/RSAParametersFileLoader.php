<?php

namespace MayMeow\Cryptography\RSA;

class RSAParametersFileLoader implements RsaParametersLoaderInterface
{
    protected $pk;

    protected $crt;

    protected $pass;

    public function __construct(string $name, $pass = null, $path = WWW_ROOT)
    {
        $pkInfo = file_get_contents(WWW_ROOT . $name . DS . 'key.pem');

        $this->pk = openssl_get_privatekey($pkInfo, $pass);

        $this->rawPublicKey = file_get_contents(WWW_ROOT . $name . DS . 'cert.crt');

        $this->crt = openssl_get_publickey($this->rawPublicKey);

        $this->pass = $pass;
    }

    public function load(): RSAParametersInterface
    {
        return new RSAParameters($this->pk, $this->crt, $this->pass, $this->rawPublicKey);
    }
}