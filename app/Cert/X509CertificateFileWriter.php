<?php

namespace MayMeow\Cryptography\Cert;

class X509CertificateFileWriter implements X509CertificateWriterInterface
{
    protected string $storagePath;

    public function __construct(string $name, string $path = WWW_ROOT)
    {
        $storagePath = $path . $name . DS;

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $this->storagePath = $storagePath;
    }

    /**
     * @param X509Certificate2 $certificate
     * @param bool $withDecriptedPK
     * @param bool $windowsFormat
     */
    public function write(X509Certificate2 $certificate, bool $withDecriptedPK = false, bool $windowsFormat = false): void
    {
        // write private key encryption password to file
        file_put_contents($this->storagePath . 'pass.txt', $certificate->getEncryptionPass());

        // write Certificate to file
        openssl_x509_export_to_file($certificate->getSignedCert(),
            $this->storagePath . 'cert.crt');

        // Write primary key to file
        openssl_pkey_export_to_file($certificate->getPrivateKey(),
            $this->storagePath . 'key.pem', $certificate->getEncryptionPass(), $certificate->getConfigArgs());

        // Create PFX
        if ($windowsFormat) {
            openssl_pkcs12_export_to_file(
                $certificate->getSignedCert(),
                $this->storagePath . 'cert.pfx',
                $certificate->getPrivateKey(),
                $certificate->getEncryptionPass(),
                $certificate->getConfigArgs()
            );
        }
    }
}
