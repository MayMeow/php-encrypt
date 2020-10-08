<?php

namespace MayMeow\Cryptography\Cert;

/**
 * Class CertParameters
 * @package MayMeow\Cryptography\Cert
 */
class CertParameters implements SerializableInterface
{
    private string $countryName;
    private string $stateOrProvinceName;
    private string $localityName;
    private string $organizationName;
    private string $organizationalUnitName;
    private string $commonName;
    private string $emailAddress;

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     * @return CertParameters
     */
    public function setCountryName(string $countryName): CertParameters
    {
        $this->countryName = $countryName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateOrProvinceName(): string
    {
        return $this->stateOrProvinceName;
    }

    /**
     * @param string $stateOrProvinceName
     * @return CertParameters
     */
    public function setStateOrProvinceName(string $stateOrProvinceName): CertParameters
    {
        $this->stateOrProvinceName = $stateOrProvinceName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocalityName(): string
    {
        return $this->localityName;
    }

    /**
     * @param string $localityName
     * @return CertParameters
     */
    public function setLocalityName(string $localityName): CertParameters
    {
        $this->localityName = $localityName;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    /**
     * @param string $organizationName
     * @return CertParameters
     */
    public function setOrganizationName(string $organizationName): CertParameters
    {
        $this->organizationName = $organizationName;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationalUnitName(): string
    {
        return $this->organizationalUnitName;
    }

    /**
     * @param string $organizationalUnitName
     * @return CertParameters
     */
    public function setOrganizationalUnitName(string $organizationalUnitName): CertParameters
    {
        $this->organizationalUnitName = $organizationalUnitName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommonName(): string
    {
        return $this->commonName;
    }

    /**
     * @param string $commonName
     * @return CertParameters
     */
    public function setCommonName(string $commonName): CertParameters
    {
        $this->commonName = $commonName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     * @return CertParameters
     */
    public function setEmailAddress(string $emailAddress): CertParameters
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function serialize()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $vars = get_object_vars($this);

        $arr = [];

        foreach ($vars as $k => $v) {
            $arr[$k] = $v;
        }

        return $arr;
    }

    /**
     * @return array
     * @deprecated
     */
    public function get() : array
    {
        return $this->toArray();
    }
}