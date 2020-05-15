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

use Symfony\Component\Yaml\Yaml;

class EncryptConfiguration
{
    protected $configFile;

    /**
     * EncryptConfiguration constructor
     * @param null $path Full path to your config file
     */
    public function __construct($path = null)
    {
        if (null == $path) {
            $this->configFile = file_get_contents(CONFIG . 'encrypt.yml');
        } else {
            $this->configFile = file_get_contents($path);
        }
    }

    /**
     * Parse configuration file
     */
    public function parse()
    {
        return Yaml::parse($this->configFile);
    }

    /**
     * @deprecated
     * @return false|string
     */
    public function get()
    {
        return $this->configFile;
    }

    /**
     * @param $templateName
     * @param null $templateRoot
     * @return string
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
        return $this->getTemplatePath('ca_certificate.cnf', $templateRoot);
    }

    public function getIntermediateTemplate($templateRoot = null)
    {
        return $this->getTemplatePath('intermediate_certificate.cnf', $templateRoot);
    }
}