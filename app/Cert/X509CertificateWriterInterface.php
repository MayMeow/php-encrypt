<?php


namespace MayMeow\Cryptography\Cert;


interface X509CertificateWriterInterface
{
    /**
     * @param X509Certificate2 $certificate
     * @param string $filePath
     * @param bool $withDecriptedPK
     * @param bool $windowsFormat
     */
    public function write(X509Certificate2 $certificate, string $filePath, bool $withDecriptedPK = false, bool $windowsFormat = false) : void;
}