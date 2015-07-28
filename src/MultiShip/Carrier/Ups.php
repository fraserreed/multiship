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
use MultiShip\Carrier\Ups\Shipment;

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
     * @return string
     */
    public function getEndPointUrl()
    {
        if( 1 == 1 /*$this->debug*/ )
            return 'https://wwwcie.ups.com/webservices/';
        else
            return 'https://onlinetools.ups.com/webservices/';
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

    /**
     * @return Ups\Shipment
     */
    public function getShipmentRequest()
    {
        return new Shipment();
    }

    protected $serviceMap = array(
        'Default' => array(
            '01' => array(
                'name'   => 'UPS Next Day Air®',
                'origin' => array(
                    'CA' => 'UPS Express'
                )
            ),
            '02' => array(
                'name'   => 'UPS Second Day Air®',
                'origin' => array(
                    'CA' => 'UPS Worldwide Expedited'
                )
            ),
            '03' => array(
                'name'   => 'UPS Ground',
                'origin' => array()
            ),
            '07' => array(
                'name'   => 'UPS Express',
                'origin' => array(
                    'US' => 'UPS Worldwide Express',
                    'PR' => 'UPS Worldwide Express'
                )
            ),
            '08' => array(
                'name'   => 'UPS Expedited',
                'origin' => array(
                    'US' => 'UPS Worldwide Expedited',
                    'PR' => 'UPS Worldwide Expedited'
                )
            ),
            '11' => array(
                'name'   => 'UPS Standard',
                'origin' => array()
            ),
            '12' => array(
                'name'   => 'UPS Three-Day Select®',
                'origin' => array()
            ),
            '13' => array(
                'name'   => 'UPS Next Day Air Saver®',
                'origin' => array(
                    'CA' => 'UPS Saver'
                )
            ),
            '14' => array(
                'name'   => 'UPS Next Day Air® Early A.M.',
                'origin' => array(
                    'CA' => 'UPS Express Early A.M.'
                )
            ),
            '54' => array(
                'name'   => 'UPS Worldwide Express Plus',
                'origin' => array(
                    'MX' => 'UPS Express Plus'
                )
            ),
            '59' => array(
                'name'   => 'UPS Second Day Air A.M.®',
                'origin' => array()
            ),
            '65' => array(
                'name'   => 'UPS Saver',
                'origin' => array()
            ),
            '82' => array(
                'name'   => 'UPS Today Standard',
                'origin' => array()
            ),
            '83' => array(
                'name'   => 'UPS Today Dedicated Courrier',
                'origin' => array()
            ),
            '85' => array(
                'name'   => 'UPS Today Express',
                'origin' => array()
            ),
            '86' => array(
                'name'   => 'UPS Today Express Saver',
                'origin' => array()
            ),
            '96' => array(
                'name'   => 'UPS Worldwide Express Freight',
                'origin' => array()
            ),
        )
    );
}
