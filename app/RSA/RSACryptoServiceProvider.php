<?php

namespace MayMeow\Cryptography\RSA;

class RSACryptoServiceProvider
{
    /**
     * @var array Configuration
     */
    protected $config = [
        'digest_alg' => 'sha512',
        'private_key_bits' => 4096,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ];

    /**
     * @var RSAParametersInterface Rsa Parameters
     */
    protected $rsaParameters;

    /**
     * RSACryptoServiceProvider constructor.
     * @param int|null $private_key_bits Length of private key
     */
    public function __construct($private_key_bits = null)
    {
        if (null !== $private_key_bits) {
            $this->config['private_key_bits'] = $private_key_bits;
        }
    }

    /**
     * @param RSAParametersInterface $rsaParameters
     */
    public function setRsaParameters(RSAParametersInterface $rsaParameters): void
    {
        $this->rsaParameters = $rsaParameters;
    }

    /**
     * @param null $passPhrase
     * @param array|null $configArgs
     * @return RSAParameters
     */
    public function generateKeyPair($passPhrase = null, array $configArgs = null): RSAParameters
    {
        $newKeyPair = openssl_pkey_new($this->config);

        openssl_pkey_export($newKeyPair, $privateKey, $passPhrase, $configArgs);
        $pubKey = openssl_pkey_get_details($newKeyPair);

        $this->rsaParameters = new RSAParameters($privateKey, $pubKey['key'], $passPhrase);;

        return $this->rsaParameters;
    }

    /**
     * Standard encryption method. You will need public key to encrypt data.
     * Can be used for data protection because need encrypt with private key.
     * Dont give you private key anyone !!!
     *
     * @param $plainText
     * @return string
     */
    public function encrypt($plainText) : string
    {
        $encrypted = '';

        openssl_public_encrypt($plainText,$encrypted, $this->rsaParameters->getPublicKey());

        return base64_encode($encrypted);
    }

    /**
     * Standard decryption method, will need private key to decrypt data previously encrypted with public key
     *
     * @param $encryptedText
     * @return string
     */
    public function decrypt($encryptedText) : string
    {
        $plainText = '';
        if ($this->rsaParameters->isPrivateKeyEncrypted()) {
            $privKey = $this->rsaParameters->decryptPrivateKey();
        } else {
            $privKey = $this->rsaParameters->getPrivateKey();
        }

        openssl_private_decrypt(base64_decode($encryptedText), $plainText, $privKey);

        return $plainText;
    }

    /**
     * Encrypt given text with private key.
     * Use it in specific situations (not for data protection) as for example license generation.
     * You can decrypt text with your public key without any protection !!!
     *
     * @param $plainText
     * @return string
     */
    public function private_encrypt($plainText) : string
    {
        $encrypted = '';
        if ($this->rsaParameters->isPrivateKeyEncrypted()) {
            $privKey = $this->rsaParameters->decryptPrivateKey();
        } else {
            $privKey = $this->rsaParameters->getPrivateKey();
        }

        openssl_private_encrypt($plainText, $encrypted, $privKey);

        return base64_encode($encrypted);
    }

    /**
     * Decrypt text which was encrypted with private key
     *
     * @param $encryptedText
     * @return string
     */
    public function public_decrypt($encryptedText) : string
    {
        $plainText = '';
        openssl_public_decrypt(base64_decode($encryptedText), $plainText, $this->rsaParameters->getPublicKey());

        return $plainText;
    }

    protected function seal(string $plain_text) : string
    {
        // todo
        //openssl_open($plain_text, $sealed_data, $ekeys, [$this->rsaParameters->getPrivateKey()])
    }

    protected function open()
    {
        // todo
    }

    /**
     * @param $data
     * @return string
     */
    public function sign($data) : string
    {
        $privKey = $this->_getPrivateKey();

        $result = openssl_sign($data, $signature, $privKey, OPENSSL_ALGO_SHA512);

        return base64_encode($signature);
    }

    /**
     * @param $data
     * @param $signature
     * @return bool
     */
    public function verify($data, $signature) : bool
    {
        $verification = openssl_verify($data, base64_decode($signature), $this->rsaParameters->getPublicKey(), OPENSSL_ALGO_SHA512);

        return (bool)$verification;
    }

    /**
     * Returns MD5 Fingerprint
     *
     * @return string
     */
    public function getFingerPrint() : string
    {
        $fingerprint = join(':', str_split(md5(base64_decode($this->rsaParameters->getPublicKey())), 2));

        return $fingerprint;
    }

    protected function _getPrivateKey()
    {
        if ($this->rsaParameters->isPrivateKeyEncrypted()) {
            $privKey = $this->rsaParameters->decryptPrivateKey();
        } else {
            $privKey = $this->rsaParameters->getPrivateKey();
        }
    }
}