<?php
/**
 * This file is part of MayMeow/encrypt project
 * Copyright (c) 2017 Charlotta Jung
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 * @copyright Copyright (c) Charlotta MayMeow Jung
 * @link      http://maymeow.click
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @project may-encrypt
 * @file AltNames.php
 */

/**
 * Created by PhpStorm.
 * User: martin
 * Date: 4/5/2017
 * Time: 9:34 AM
 */

namespace MayMeow\Model;

use MayMeow\Cryptography\Authority\CertificateAuthorityConfigurationInterface;
use MayMeow\Cryptography\Authority\DefaultCertificateAuthorityConfiguration;
use Symfony\Component\Yaml\Yaml;

/**
 * Class EncryptConfiguration
 * @package MayMeow\Model
 * @deprecated Use DefaultCertificateAuthorityConfiguration
 * @see \MayMeow\Cryptography\Authority\CertificateAuthorityConfigurationInterface
 */
class EncryptConfiguration
{
    protected CertificateAuthorityConfigurationInterface $cfg;

    /**
     * EncryptConfiguration constructor
     * @param null $path Full path to your config file
     */
    public function __construct($path = null)
    {
        $this->cfg = DefaultCertificateAuthorityConfiguration::getInstance($path);
    }

    public function defaultConfiguration() : CertificateAuthorityConfigurationInterface
    {
        return  $this->cfg;
    }

    /**
     * Parse configuration file
     * @deprecated it can be called in constructor of Encrypt configuration
     */
    public function parse()
    {
        return $this->cfg->getConfiguration();
    }

    /**
     * @param $templateName
     * @param null $templateRoot
     * @return string
     * @deprecated no more used
     */
    public function getTemplatePath($templateName, $templateRoot = null)
    {
        if ($templateRoot == null) $templateRoot = TEMPLATE_ROOT;

        return $templateRoot . $templateName;
    }

    /**
     * @param null $templateRoot
     * @return string
     */
    public function getCaTemplate($templateRoot = null)
    {
        return $this->cfg->getCaCertificateTemplate();
    }

    public function getIntermediateTemplate($templateRoot = null)
    {
        return $this->cfg->getIntermediateCaCertificateTemplate();
    }
}