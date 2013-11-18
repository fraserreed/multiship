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
namespace MultiShip\Carrier\Ups;


use MultiShip\Carrier\Ups;
use MultiShip\Request\AbstractRate;

use MultiShip\Response\Collections\Rate as RateCollection;
use MultiShip\Response\Elements\SimpleRate as RateElement;
use MultiShip\Charge\TotalCharge;
use MultiShip\Package\Package;

use MultiShip\Exceptions\MultiShipException;

/**
 * MultiShip shipper object
 *
 * @author fraserreed
 */
class SimpleRate extends AbstractRate
{
    protected $operation = "ProcessRate";

    public function getRequestBody()
    {
        $fromAddress = $this->getFromAddress();
        $toAddress   = $this->getToAddress();

        $packages = array();

        if( empty( $this->packages ) )
            throw new MultiShipException( 'At least one package must be provided for all rate requests.' );

        /** @var $package \MultiShip\Package\Package */
        foreach( $this->packages as $package )
        {
            $packages[ ] = array(
                'PackagingType' => array(
                    'Code'        => '02',
                    'Description' => 'Rate'
                ),
                'Dimensions'    => array(
                    'Length'            => $package->getLength(),
                    'Width'             => $package->getWidth(),
                    'Height'            => $package->getHeight(),
                    'UnitOfMeasurement' => array(
                        'Code'        => $package->getDimensionUnitOfMeasure(),
                        'Description' => $package->getDimensionUnitOfMeasureDescription()
                    )
                ),
                'PackageWeight' => array(
                    'Weight'            => $package->getWeight(),
                    'UnitOfMeasurement' => array(
                        'Code'        => $package->getWeightUnitOfMeasure(),
                        'Description' => $package->getWeightUnitOfMeasureDescription()
                    )
                )
            );
        }

        $request = array(
            'Request'                => array(
                'RequestOption' => 'Shop'
            ),
            'PickupType'             => array(
                'Code'        => '01',
                'Description' => 'Daily Pickup'

            ),
            'CustomerClassification' => array(
                'Code'        => '01',
                'Description' => 'Classfication'
            ),
            'Shipment'               => array(
                'Shipper'                => array(
                    'Name'          => $fromAddress->getName(),
                    'ShipperNumber' => $fromAddress->getNumber(),
                    'Address'       => array(
                        'AddressLine'       => array(
                            $fromAddress->getLine1(),
                            $fromAddress->getLine2(),
                            $fromAddress->getLine3()
                        ),
                        'City'              => $fromAddress->getCity(),
                        'StateProvinceCode' => $fromAddress->getRegion(),
                        'PostalCode'        => $fromAddress->getPostalCode(),
                        'CountryCode'       => $fromAddress->getCountry()
                    )
                ),

                'ShipTo'                 => array(
                    'Name'    => $toAddress->getName(),
                    'Address' => array(
                        'AddressLine'                 => $toAddress->getLine1(),
                        'City'                        => $toAddress->getCity(),
                        'StateProvinceCode'           => $toAddress->getRegion(),
                        'PostalCode'                  => $toAddress->getPostalCode(),
                        'CountryCode'                 => $toAddress->getCountry(),
                        'ResidentialAddressIndicator' => ''
                    )
                ),

                'ShipFrom'               => array(
                    'Name'    => $fromAddress->getName(),
                    'Address' => array(
                        'AddressLine'       => array(
                            $fromAddress->getLine1(),
                            $fromAddress->getLine2(),
                            $fromAddress->getLine3()
                        ),
                        'City'              => $fromAddress->getCity(),
                        'StateProvinceCode' => $fromAddress->getRegion(),
                        'PostalCode'        => $fromAddress->getPostalCode(),
                        'CountryCode'       => $fromAddress->getCountry()
                    )
                ),

                'Service'                => array(
                    'Code'        => '03',
                    'Description' => 'Service Code'
                ),

                'Package'                => $packages,
                'ShipmentServiceOptions' => '',
                'LargePackageIndicator'  => ''
            )
        );

        return $request;
    }

    /**
     * @param $response
     *
     * @return \MultiShip\Response\Collections\Rate
     */
    public function parseResponse( $response )
    {
        $rateResponse = new RateCollection();

        $rateResponse->setStatusCode( $response->Response->ResponseStatus->Code );
        $rateResponse->setStatusDescription( $response->Response->ResponseStatus->Description );

        if( count( $response->RatedShipment ) > 0 )
        {
            $rateResponse->setCount( (int) count( $response->RatedShipment ) );

            foreach( $response->RatedShipment as $rate )
            {
                $rateElement = new RateElement();

                //service code
                if( isset( $rate->Service ) )
                {
                    $rateElement->setServiceCode( $rate->Service->Code );
                }

                //total charges
                if( isset( $rate->TotalCharges ) )
                {
                    $totalCharges = new TotalCharge();
                    $totalCharges->setCurrencyCode( $rate->TotalCharges->CurrencyCode );
                    $totalCharges->setValue( $rate->TotalCharges->MonetaryValue );

                    $rateElement->setTotal( $totalCharges );
                }

                $rateResponse->addRate( $rateElement );
            }
        }

        return $rateResponse;
    }
}

?>