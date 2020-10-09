<?php

namespace MayMeow\Cryptography\Authority;

interface CertificateAuthorityInterface
{
    /**
     * @return CertificateAuthorityConfigurationInterface
     */
    public function getDefaultConfiguration() : CertificateAuthorityConfigurationInterface;
}