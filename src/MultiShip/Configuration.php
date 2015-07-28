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
namespace MultiShip;


/**
 * MultiShip config object
 *
 * @author fraserreed
 */
class Configuration
{

    /**
     * @var string
     */
    protected $accessKey;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $accountNumber;

    /**
     * @var string
     */
    protected $meterNumber;

    /**
     * @var string
     */
    protected $wsdl;

    /**
     * @var string
     */
    protected $endPointUrl;

    /**
     * @param string $accessKey
     */
    public function setAccessKey( $accessKey )
    {
        $this->accessKey = $accessKey;
    }

    /**
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * @param string $endPointUrl
     */
    public function setEndPointUrl( $endPointUrl )
    {
        $this->endPointUrl = $endPointUrl;
    }

    /**
     * @return string
     */
    public function getEndPointUrl()
    {
        return $this->endPointUrl;
    }

    /**
     * @param string $password
     */
    public function setPassword( $password )
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $userId
     */
    public function setUserId( $userId )
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $accountNumber
     */
    public function setAccountNumber( $accountNumber )
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string $meterNumber
     */
    public function setMeterNumber( $meterNumber )
    {
        $this->meterNumber = $meterNumber;
    }

    /**
     * @return string
     */
    public function getMeterNumber()
    {
        return $this->meterNumber;
    }

    /**
     * @param string $wsdl
     */
    public function setWsdl( $wsdl )
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @return string
     */
    public function getWsdl()
    {
        return $this->wsdl;
    }
}

