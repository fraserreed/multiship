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
        throw new \MultiShip\Exceptions\MultiShipException( 'Not implemented yet.' );
    }
}

?>