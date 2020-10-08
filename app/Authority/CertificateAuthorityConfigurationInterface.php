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
}