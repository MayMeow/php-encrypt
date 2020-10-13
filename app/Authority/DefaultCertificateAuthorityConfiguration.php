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
        'user' => 'intermediate_certificate.cnf',
        'server' => 'intermediate_certificate.cnf',
        'code_sign' => 'intermediate_certificate.cnf',
        'intermediate' => 'intermediate_certificate.cnf',
    ];

    private function __construct(?string $path = null)
    {
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
        return $this->_buildPath('ca');
    }

    /**
     * Returns path to Intermediate CA certificate template
     *
     * @return string
     */
    public function getIntermediateCaCertificateTemplate(): string
    {
        return $this->_buildPath('intermediate');
    }

    /**
     * @param string $type
     * @return string
     */
    private function _buildPath(string $type) : string
    {
        if (array_key_exists('template_root_path', $this->config)) {
            $templateRoot = $this->config['template_root_path'];
        } else {
            $templateRoot = TEMPLATE_ROOT;
        }

        return $templateRoot . $this->config[$type];
    }

    /**
     * @inheritDoc
     */
    public function getUserCertificateTemplate(): string
    {
        return $this->_buildPath('user');
    }

    /**
     * @inheritDoc
     */
    public function getServerCertificateTemplate(): string
    {
        return $this->_buildPath('server');
    }

    /**
     * @inheritDoc
     */
    public function getCodeSigningCertificateTemplate(): string
    {
        return $this->_buildPath('code_sign');
    }
}