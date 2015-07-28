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
namespace MultiShip\Request;


use Exception;

use MultiShip\Response\Collections\Shipment;

/**
 * MultiShip shipment object
 *
 * @author fraserreed
 */
abstract class AbstractShipment extends AbstractRequest implements IShipment
{
    /**
     * @var string
     */
    protected $type = 'Shipment';

    protected $serviceCode;

    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    /**
     * Handle exception thrown from soap request
     *
     * @param $e
     *
     * @return mixed
     */
    public function handleException( Exception $e )
    {
        $shipmentResponse = new Shipment();

        if( isset( $e->detail->Errors->ErrorDetail ) )
        {
            $shipmentResponse->setStatusCode( $e->detail->Errors->ErrorDetail->PrimaryErrorCode->Code );
            $shipmentResponse->setStatusDescription( $e->detail->Errors->ErrorDetail->PrimaryErrorCode->Description );
        }
        else
        {
            $shipmentResponse->setStatusCode( $e->getCode() );
            $shipmentResponse->setStatusDescription( $e->getMessage() );
        }

        $shipmentResponse->setDetail( $this->getRequestBody() );
        $shipmentResponse->setCount( 0 );

        return $shipmentResponse;
    }
}
