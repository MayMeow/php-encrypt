<?php

namespace MayMeow\Cryptography\Authority;

use MayMeow\Cryptography\Exceptions\NotImplementedException;
use Symfony\Component\Yaml\Yaml;

class DefaultCertificateAuthorityConfiguration implements CertificateAuthorityConfigurationInterface
{
    private string $caCertificateTemplatePath;
    private string $intermediateCaTemplateTemplatePath;

    /**
     * @var mixed
     */
    private $authorityConfiguration;

    /**
     * @var array Default config
     */
    protected array $config = [
        'ca' => 'ca_certificate.cnf',
        'intermediate' => 'intermediate_certificate.cnf'
    ];

    private function __construct(?string $path = null)
    {
        $this->_buildPaths();

        $configFilePath = '';

        if ($path == null) {
            $configFilePath = file_get_contents(CONFIG . 'encrypt.yml');
        } else {
            $configFilePath = file_get_contents($path);
        }

        $this->authorityConfiguration = Yaml::parse($configFilePath);
    }

    /**
     * @param string|null $path
     * @return DefaultCertificateAuthorityConfiguration
     */
    public static function getInstance(?string $path = null) : DefaultCertificateAuthorityConfiguration
    {
        return new static($path);
    }

    /**
     * @return mixed
     */
    public function getConfiguration()
    {
        return $this->authorityConfiguration;
    }

    /**
     * Returns path to CA certificate template
     *
     * @return string
     */
    public function getCaCertificateTemplate(): string
    {
        return $this->caCertificateTemplatePath;
    }

    /**
     * Returns path to Intermediate CA certificate template
     *
     * @return string
     */
    public function getIntermediateCaCertificateTemplate(): string
    {
        return $this->intermediateCaTemplateTemplatePath;
    }

    /**
     * Create template paths
     */
    private function _buildPaths() : void
    {
        if (array_key_exists('template_root_path', $this->config)) {
            $templateRoot = $this->config['template_root_path'];
        } else {
            $templateRoot = TEMPLATE_ROOT;
        }

        $this->intermediateCaTemplateTemplatePath = $templateRoot . $this->config['intermediate'];
        $this->caCertificateTemplatePath = $templateRoot . $this->config['ca'];
    }
}