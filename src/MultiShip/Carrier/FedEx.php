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
            for( $i = 0; $i < 1000; $i++ )
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
}

?>