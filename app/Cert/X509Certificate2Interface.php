<?php

namespace MayMeow\Cryptography\Cert;

interface X509Certificate2Interface
{
    /**
     * Return ConfigArgs for signed certificate
     *
     * @return array|null
     */
    public function getConfigArgs(): ?array;

    /**
     * Return original certificate parameters from which it was created
     *
     * @return CertParameters
     */
    public function getCertParameters(): CertParameters;

    /**
     * @return mixed
     */
    public function getPrivateKey();

    /**
     * @return mixed
     */
    public function getSignedCert();

    /**
     * @return int
     */
    public function getEncryptionPass();

    /**
     * Sign certificate with Certification authority
     * @param $daysValid
     * @param $caCertificate
     * @param $caKey
     * @param array|null $certConfiguration
     */
    public function sign($caCertificate, $caKey, $daysValid, array $certConfiguration = null);

    /**
     * Create self-signed certificate
     *
     * @param $daysValid
     * @param array|null $certConfiguration
     */
    public function selfSigned($daysValid, array $certConfiguration = null);
}