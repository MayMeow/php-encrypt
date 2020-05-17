<?php

namespace MayMeow\Cryptography\Cert;

class CertParameters
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
     * @return CertParameters
     */
    public function setCountryName($countryName)
    {
        $this->config['countryName'] = $countryName;

        return $this;
    }

    /**
     * @param mixed $stateOrProvinceName
     * @return CertParameters
     */
    public function setStateOrProvinceName($stateOrProvinceName)
    {
        $this->config['stateOrProvinceName'] = $stateOrProvinceName;
        //$this->stateOrProvinceName = $stateOrProvinceName;

        return $this;
    }

    /**
     * @param mixed $localityName
     * @return CertParameters
     */
    public function setLocalityName($localityName)
    {
        $this->config['localityName'] = $localityName;
        //$this->localityName = $localityName;

        return $this;
    }

    /**
     * @param mixed $organizationName
     * @return CertParameters
     */
    public function setOrganizationName($organizationName)
    {
        //$this->organizationName = $organizationName;
        $this->config['organizationName'] = $organizationName;
        return $this;
    }

    /**
     * @param mixed $organizationalUnitName
     * @return CertParameters
     */
    public function setOrganizationalUnitName($organizationalUnitName)
    {
        $this->config['organizationalUnitName'] = $organizationalUnitName;
        //$this->organizationalUnitName = $organizationalUnitName;

        return $this;
    }

    /**
     * @param mixed $commonName
     * @return CertParameters
     */
    public function setCommonName($commonName)
    {
        $this->config['commonName'] = $commonName;
        //$this->commonName = $commonName;

        return $this;
    }

    /**
     * @param mixed $emailAddress
     * @return CertParameters
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