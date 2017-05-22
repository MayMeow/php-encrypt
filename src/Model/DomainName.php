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
 * @file DomainName.php
 */

namespace MayMeow\Model;

class DomainName
{
    /*private $countryName;
    private $stateOrProvinceName;
    private $localityName;
    private $organizationName;
    private $organizationalUnitName;
    private $commonName;
    private $emailAddress;*/

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param mixed $countryName
     * @return DomainName
     */
    public function setCountryName($countryName)
    {
        $this->config['countryName'] = $countryName;

        return $this;
    }

    /**
     * @param mixed $stateOrProvinceName
     * @return DomainName
     */
    public function setStateOrProvinceName($stateOrProvinceName)
    {
        $this->config['stateOrProvinceName'] = $stateOrProvinceName;
        //$this->stateOrProvinceName = $stateOrProvinceName;

        return $this;
    }

    /**
     * @param mixed $localityName
     * @return DomainName
     */
    public function setLocalityName($localityName)
    {
        $this->config['localityName'] = $localityName;
        //$this->localityName = $localityName;

        return $this;
    }

    /**
     * @param mixed $organizationName
     * @return DomainName
     */
    public function setOrganizationName($organizationName)
    {
        //$this->organizationName = $organizationName;
        $this->config['organizationName'] = $organizationName;
        return $this;
    }

    /**
     * @param mixed $organizationalUnitName
     * @return DomainName
     */
    public function setOrganizationalUnitName($organizationalUnitName)
    {
        $this->config['organizationalUnitName'] = $organizationalUnitName;
        //$this->organizationalUnitName = $organizationalUnitName;

        return $this;
    }

    /**
     * @param mixed $commonName
     * @return DomainName
     */
    public function setCommonName($commonName)
    {
        $this->config['commonName'] = $commonName;
        //$this->commonName = $commonName;

        return $this;
    }

    /**
     * @param mixed $emailAddress
     * @return DomainName
     */
    public function setEmailAddress($emailAddress)
    {
        $this->config['emailAddress'] = $emailAddress;
        //$this->emailAddress = $emailAddress;

        return $this;
    }

    public function serialize() {
        //$properties = get_object_vars($this);

        return json_encode($this->config);
    }

    public function get()
    {
        return $this->config;
    }
}
