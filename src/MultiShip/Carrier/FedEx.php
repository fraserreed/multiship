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


use MultiShip\Exceptions\MultiShipException;
use MultiShip\Request\IRequest;

use MultiShip\Carrier\FedEx\Rate;
use MultiShip\Carrier\FedEx\SimpleRate;
use MultiShip\Carrier\FedEx\Shipment;

/**
 * FedEx shipping carrier object
 *
 * Testing and integration URL : https://wsbeta.fedex.com:443/web-services/rate
 * Production URL : https://ws.fedex.com:443/web-services/rate
 *
 * @author fraserreed
 */
class FedEx extends AbstractCarrier
{
    /**
     * @return string
     */
    public function getCarrierCode()
    {
        return 'FedEx';
    }

    /**
     * @return string
     */
    public function getEndPointUrl()
    {
        if( 1 == 1 /*$this->debug*/ )
            return 'https://wsbeta.fedex.com:443/web-services/';
        else
            return 'https://ws.fedex.com:443/web-services/';
    }

    /**
     * FedEx has no additional soap headers
     *
     * @return \SoapHeader|void
     */
    public function getSoapHeader()
    {
        return;
    }

    /**
     * @return FedEx\Rate
     */
    public function getRateRequest()
    {
        return new Rate();
    }

    /**
     * @return FedEx\SimpleRate
     */
    public function getSimpleRateRequest()
    {
        return new SimpleRate();
    }

    /**
     * @return FedEx\Shipment
     */
    public function getShipmentRequest()
    {
        return new Shipment();
    }

    /**
     * @param IRequest $request
     *
     * @throws \MultiShip\Exceptions\MultiShipException
     * @return mixed
     */
    public function request( IRequest $request )
    {
        //if the request is a shipment, there may be multiple packages
        // requiring multiple requests
        if( $request instanceof Shipment )
        {
            //set threshold for loop to prevent a runaway
            // fedex allows a maximum of 100 packages per shipment
            for( $i = 0; $i < 100; $i++ )
            {
                //only make requests until shipment is complete
                if( $request->isShipmentComplete() == true )
                    break;

                $response = parent::request( $request );
            }

            //if there is a valid response, return it
            if( isset( $response ) )
                return $response;

            throw new MultiShipException( 'Error completing shipment request.' );
        }

        return parent::request( $request );
    }

    protected $serviceMap = array(
        'Default' => array(
            'FEDEX_1_DAY_FREIGHT'                 => array(
                'name' => 'FedEx 1 Day Freight'
            ),
            'FEDEX_2_DAY'                         => array(
                'name' => 'FedEx 2 Day'
            ),
            'FEDEX_2_DAY_AM'                      => array(
                'name' => 'FedEx 2 Day AM'
            ),
            'FEDEX_2_DAY_FREIGHT'                 => array(
                'name' => 'FedEx 2 Day Freight'
            ),
            'FEDEX_3_DAY_FREIGHT'                 => array(
                'name' => 'FedEx 3 Day Freight'
            ),
            'FEDEX_EXPRESS_SAVER'                 => array(
                'name' => 'FedEx Express Saver'
            ),
            'FEDEX_GROUND'                        => array(
                'name' => 'FedEx Ground'
            ),
            'FIRST_OVERNIGHT'                     => array(
                'name' => 'First Overnight'
            ),
            'GROUND_HOME_DELIVERY'                => array(
                'name' => 'Ground Home Delivery'
            ),
            'INTERNATIONAL_ECONOMY'               => array(
                'name' => 'International Economy'
            ),
            'INTERNATIONAL_ECONOMY_FREIGHT'       => array(
                'name' => 'International Economy Freight'
            ),
            'INTERNATIONAL_FIRST'                 => array(
                'name' => 'International First'
            ),
            'INTERNATIONAL_PRIORITY'              => array(
                'name' => 'International Priority'
            ),
            'INTERNATIONAL_PRIORITY_FREIGHT'      => array(
                'name' => 'International Priority Freight'
            ),
            'PRIORITY_OVERNIGHT'                  => array(
                'name' => 'Priority Overnight'
            ),
            'SMART_POST'                          => array(
                'name' => 'Smart Post'
            ),
            'STANDARD_OVERNIGHT'                  => array(
                'name' => 'Standard Overnight'
            ),
            'FEDEX_FREIGHT'                       => array(
                'name' => 'FedEx Freight'
            ),
            'FEDEX_NATIONAL_FREIGHT'              => array(
                'name' => 'FedEx National Freight'
            ),
            'EUROPE_FIRST_INTERNATIONAL_PRIORITY' => array(
                'name' => 'Europe First International Priority'
            )
        )
    );
}
