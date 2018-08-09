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

class EncryptConfiguration
{
    protected $configFile;

    public function __construct($path = null)
    {
        if (null == $path) {
            $this->configFile = file_get_contents(CONFIG . 'encrypt.yml');
        } else {
            $this->configFile = file_get_contents($path);
        }
    }

    public function get()
    {
        return $this->configFile;
    }
}