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
 * @file app.php
 */

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 * dirname — Returns a parent directory's path
 */
define('ROOT', dirname(__DIR__));

/**
 * The full path to the actual working directory directory, WITHOUT a trailing DS.
 * Important if you want use script as commandline utility globally
 * getcwd — Gets the current working directory
 */
define('CLI_ROOT', getcwd());

/**
 * File path to the webroot directory.
 * To use as commandline globally change ROOT to CLI_ROOT.
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * File path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path for certificate Templates
 */
define('TEMPLATE_ROOT', CONFIG . 'templates' . DS);

/**
 * Path to config inside phar
 */
//define('CONFIG', 'phar://php-encrypt.phar/config/');