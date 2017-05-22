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

class AltNames
{
    /**
     * IP address
     * @var array
     */
    protected $ip = [];

    /**
     * Domain Name
     * @var array
     */
    protected $dns = [];

    /**
     * URL address
     * @var array
     */
    protected $url = [];

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return AltNames
     */
    public function setIp($ip)
    {
        $this->ip[] = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDns()
    {
        return $this->dns;
    }

    /**
     * @param mixed $dns
     * @return AltNames
     */
    public function setDns($dns)
    {
        $this->dns[] = $dns;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return AltNames
     */
    public function setUrl($url)
    {
        $this->url[] = $url;
        return $this;
    }

    /**
     * Method toString
     *
     * Returns altnames formated for CNF files
     * @return string
     */
    public function toString()
    {
        $newLine = "\n";
        $string = $newLine . $newLine;

        $i = 0;
        foreach ($this->dns as $dns) {
            ++$i;
            $string .= 'DNS.' . $i . ' = ' . $dns .$newLine;
        }

        $i = 0;
        foreach ($this->ip as $ip) {
            ++$i;
            $string .= 'IP.' . $i . ' = ' . $ip .$newLine;
        }

        $i = 0;
        foreach ($this->url as $url) {
            ++$i;
            $string .= 'URL.' . $i . ' = ' . $url .$newLine;
        }

        return $string;
    }


}