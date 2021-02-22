<?php

namespace MayMeow\Cryptography\Authority;

use MayMeow\Cryptography\Cert\CertParameters;
use MayMeow\Cryptography\Cert\X509Certificate2;
use MayMeow\Cryptography\RSA\RSAParametersInterface;

/**
 * Class CertificateAuthority
 * @package MayMeow\Cryptography\Authority
 */
class CertificateAuthority implements CertificateAuthorityInterface
{
    /**
     * @var CertificateAuthorityConfigurationInterface|DefaultCertificateAuthorityConfiguration
     */
    protected CertificateAuthorityConfigurationInterface $authorityConfiguration;

    /**
     * @var CertificateConfigArgs
     */
    protected CertificateConfigArgs $configArgs;

    /**
     * CertificateAuthority constructor.
     * @param CertificateAuthorityConfigurationInterface|null $authorityConfiguration
     */
    public function __construct(?CertificateAuthorityConfigurationInterface $authorityConfiguration = null)
    {
        // Load certificate template paths config & standard configuration for certificates
        if ($authorityConfiguration != null) {
            $this->authorityConfiguration = $authorityConfiguration;
        } else {
            $this->authorityConfiguration = DefaultCertificateAuthorityConfiguration::getInstance();
        }

        // Configuration arguments loaded from templates
        $this->configArgs = CertificateConfigArgs::getInstance($this);
    }

    /**
     * @return CertificateAuthorityConfigurationInterface
     */
    public function getDefaultConfiguration(): CertificateAuthorityConfigurationInterface
    {
        return  $this->authorityConfiguration;
    }

    /**
     * @param CertParameters $certParameters
     * @param string $type
     * @param int $daysValid
     * @return X509Certificate2
     */
    public function createSelfSigned(CertParameters $certParameters, string $type, int $daysValid = 365) : X509Certificate2
    {
        $certificate = new X509Certificate2($certParameters, $this->configArgs->getArgs($type));

        $certificate->selfSigned($daysValid);

        return $certificate;
    }

    public function sign(CertParameters $certParameters, RSAParametersInterface $authority, string $type, int $daysValid = 365) : X509Certificate2
    {
        $certificate = new X509Certificate2($certParameters, $this->configArgs->getArgs($type));

        $authority->decryptPrivateKey();

        $certificate->sign($authority->getCertifcate(), $authority->getPrivateKey(), $daysValid);

        return $certificate;
    }
}