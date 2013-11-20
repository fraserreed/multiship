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
namespace MultiShip\Carrier;


use SoapHeader;
use MultiShip\Carrier\Ups\Rate;
use MultiShip\Carrier\Ups\SimpleRate;

/**
 * Ups shipping carrier object
 *
 * Testing and integration URL : https://wwwcie.ups.com/webservices/Rate
 * Production URL : https://onlinetools.ups.com/webservices/Rate
 *
 * @author fraserreed
 */
class Ups extends AbstractCarrier
{
    /**
     * @return string
     */
    public function getCarrierCode()
    {
        return 'Ups';
    }

    /**
     * @return SoapHeader
     */
    public function getSoapHeader()
    {
        $config = $this->getConfiguration();

        return new SoapHeader(
            'http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0',
            'UPSSecurity',
            array(
                 'UsernameToken'      => array(
                     'Username' => $config->getUserId(),
                     'Password' => $config->getPassword()
                 ),
                 'ServiceAccessToken' => array(
                     'AccessLicenseNumber' => $config->getAccessKey()
                 )
            )
        );
    }

    /**
     * @return Ups\Rate
     */
    public function getRateRequest()
    {
        return new Rate();
    }

    /**
     * @return Ups\SimpleRate
     */
    public function getSimpleRateRequest()
    {
        return new SimpleRate();
    }
}

?>