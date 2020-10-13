<?php

namespace MayMeow\Cryptography\Authority;

interface CertificateAuthorityConfigurationInterface
{
    /**
     * @return mixed
     */
    public function getConfiguration();

    /**
     * @return string
     */
    public function getCaCertificateTemplate() : string;

    /**
     * @return string
     */
    public function getIntermediateCaCertificateTemplate() : string;

    /**
     * @return string
     */
    public function getUserCertificateTemplate() : string;

    /**
     * @return string
     */
    public function getServerCertificateTemplate() : string;

    /**
     * @return string
     */
    public function getCodeSigningCertificateTemplate() : string;
}