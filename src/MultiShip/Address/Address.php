<?php

/*
 * This file is part of the MultiShip package.
 *
 * (c) 2013 Fraser Reed
 *      <fraser.reed@gmail.com>
 *      github.com/fraserreed
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MultiShip\Address;


/**
 * MultiShip address object
 *
 * @author fraserreed
 */
class Address
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $line1;

    /**
     * @var string
     */
    protected $line2;

    /**
     * @var string
     */
    protected $line3;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $postalCode;

    /**
     * @var string
     */
    protected $country;

    /**
     * @param string $type
     */
    public function setType( $type )
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $company
     */
    public function setCompany( $company )
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $number
     */
    public function setNumber( $number )
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber( $phoneNumber )
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $line1
     */
    public function setLine1( $line1 )
    {
        $this->line1 = $line1;
    }

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @param string $line2
     */
    public function setLine2( $line2 )
    {
        $this->line2 = $line2;
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * @param string $line3
     */
    public function setLine3( $line3 )
    {
        $this->line3 = $line3;
    }

    /**
     * @return string
     */
    public function getLine3()
    {
        return $this->line3;
    }

    /**
     * @param string $city
     */
    public function setCity( $city )
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $region
     */
    public function setRegion( $region )
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode( $postalCode )
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $country
     */
    public function setCountry( $country )
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}

?>