<?php

namespace MayMeow\Cryptography\Authority;

use MayMeow\Cryptography\Cert\X509Certificate2;

/**
 * Class CertificateConfigArgs
 *
 * Genereating config args for openssl
 *
 * @package MayMeow\Cryptography\Authority
 */
class CertificateConfigArgs
{
    protected string $config;

    protected string $x509_extensions;

    protected string $private_key_bits;

    protected CertificateAuthorityConfigurationInterface $authorityConfiguration;

    /**
     * CertificateConfigArgs constructor.
     * @param CertificateAuthorityInterface $authorityConfiguration
     */
    private function __construct(CertificateAuthorityInterface $authorityConfiguration)
    {
        $this->authorityConfiguration = $authorityConfiguration->getDefaultConfiguration();
    }

    /**
     * @param CertificateAuthorityInterface $authorityConfiguration
     * @return static
     */
    public static function getInstance(CertificateAuthorityInterface $authorityConfiguration)
    {
        return new static($authorityConfiguration);
    }

    /**
     * @param string $certificateType
     * @return array
     *
     * TODO Add Alternative names and if they are not null create alternative configuration in forlder,
     * where certificate will be created
     */
    public function getArgs(string $certificateType): array
    {
        $this->_buildArgs($certificateType);

        return $this->toArray();
    }

    /**
     * @param string $certificateType
     */
    private function _buildArgs(string $certificateType): void
    {
        if ($certificateType == X509Certificate2::TYPE_CA) {
            $this->config = $this->authorityConfiguration->getCaCertificateTemplate();
        } else if ($certificateType == X509Certificate2::TYPE_USER) {
            $this->config = $this->authorityConfiguration->getUserCertificateTemplate();
        } else if ($certificateType == X509Certificate2::TYPE_SERVER) {
            $this->config = $this->authorityConfiguration->getServerCertificateTemplate();
        } else if ($certificateType == X509Certificate2::TYPE_CODE_SIGN) {
            $this->config = $this->authorityConfiguration->getCodeSigningCertificateTemplate();
        } else {
            $this->config = $this->authorityConfiguration->getIntermediateCaCertificateTemplate();
        }

        $this->x509_extensions = $this->authorityConfiguration->getConfiguration()['certificates'][$certificateType]['x509_extensions'];
        $this->private_key_bits = $this->authorityConfiguration->getConfiguration()['default']['private_key_bits'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $configArgs = [];
        foreach (get_object_vars($this) as $k => $v) {
            $configArgs[$k] = $v;
        }

        return $configArgs;
    }
}