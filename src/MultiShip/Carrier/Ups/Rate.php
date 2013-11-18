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

use MultiShip\Response\Collections\Rate as RateCollection;
use MultiShip\Response\Elements\Note;
use MultiShip\Response\Elements\Rate as RateElement;
use MultiShip\Charge\TransportationCharge;
use MultiShip\Charge\ServiceCharge;
use MultiShip\Charge\TotalCharge;
use MultiShip\Response\Elements\DeliveryGuarantee;
use MultiShip\Package\Package;
use MultiShip\Package\RatedPackage;

/**
 * MultiShip shipper object
 *
 * @author fraserreed
 */
class Rate extends SimpleRate
{
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

        if( count( $response->Response->Alert ) > 0 )
        {
            foreach( $response->Response->Alert as $alert )
            {
                $note = new Note();
                $note->setCode( $alert->Code );
                $note->setDescription( $alert->Description );

                $rateResponse->addNote( $note );
            }
        }

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

                //rate notes
                if( isset( $rate->RatedShipmentAlert ) )
                {
                    foreach( $rate->RatedShipmentAlert as $alert )
                    {
                        $note = new Note();
                        $note->setCode( $alert->Code );
                        $note->setDescription( $alert->Description );

                        $rateElement->addNote( $note );
                    }
                }

                //billing weight
                if( isset( $rate->BillingWeight ) )
                {
                    $billingPackage = new Package();
                    $billingPackage->setWeight( $rate->BillingWeight->Weight );
                    $billingPackage->setWeightUnitOfMeasure( $rate->BillingWeight->UnitOfMeasurement->Code );

                    $rateElement->setBillingPackage( $billingPackage );
                }

                //transportation charges
                if( isset( $rate->TransportationCharges ) )
                {
                    $transportationCharges = new TransportationCharge();
                    $transportationCharges->setCurrencyCode( $rate->TransportationCharges->CurrencyCode );
                    $transportationCharges->setValue( $rate->TransportationCharges->MonetaryValue );

                    $rateElement->addCharge( $transportationCharges );
                }

                //service charges
                if( isset( $rate->ServiceOptionsCharges ) )
                {
                    $serviceCharges = new ServiceCharge();
                    $serviceCharges->setCurrencyCode( $rate->ServiceOptionsCharges->CurrencyCode );
                    $serviceCharges->setValue( $rate->ServiceOptionsCharges->MonetaryValue );

                    $rateElement->addCharge( $serviceCharges );
                }

                //total charges
                if( isset( $rate->TotalCharges ) )
                {
                    $totalCharges = new TotalCharge();
                    $totalCharges->setCurrencyCode( $rate->TotalCharges->CurrencyCode );
                    $totalCharges->setValue( $rate->TotalCharges->MonetaryValue );

                    $rateElement->addCharge( $totalCharges );

                    $rateElement->setTotal( $totalCharges );
                }

                //delivery time
                if( isset( $rate->GuaranteedDelivery ) )
                {

                    $deliveryGuarantee = new DeliveryGuarantee();

                    if( isset( $rate->GuaranteedDelivery->BusinessDaysInTransit ) )
                        $deliveryGuarantee->setBusinessDaysInTransit( $rate->GuaranteedDelivery->BusinessDaysInTransit );

                    if( isset( $rate->GuaranteedDelivery->DeliveryByTime ) )
                        $deliveryGuarantee->setDeliveryTime( $rate->GuaranteedDelivery->DeliveryByTime );

                    $rateElement->setDeliveryGuarantee( $deliveryGuarantee );
                }

                //rated packages
                if( count( $rate->RatedPackage ) > 0 )
                {
                    foreach( $rate->RatedPackage as $package )
                    {
                        $ratedPackage = new RatedPackage();

                        if( isset( $package->TransportationCharges ) )
                        {
                            $packageTransportCharges = new TransportationCharge();
                            $packageTransportCharges->setCurrencyCode( $package->TransportationCharges->CurrencyCode );
                            $packageTransportCharges->setValue( $package->TransportationCharges->MonetaryValue );

                            $ratedPackage->addCharge( $packageTransportCharges );
                        }

                        if( isset( $package->ServiceOptionsCharges ) )
                        {
                            $packageServiceCharges = new ServiceCharge();
                            $packageServiceCharges->setCurrencyCode( $package->ServiceOptionsCharges->CurrencyCode );
                            $packageServiceCharges->setValue( $package->ServiceOptionsCharges->MonetaryValue );

                            $ratedPackage->addCharge( $packageServiceCharges );
                        }

                        if( isset( $package->TotalCharges ) )
                        {
                            $packageTotalCharges = new TotalCharge();
                            $packageTotalCharges->setCurrencyCode( $package->TotalCharges->CurrencyCode );
                            $packageTotalCharges->setValue( $package->TotalCharges->MonetaryValue );

                            $ratedPackage->addCharge( $packageTotalCharges );
                        }

                        $ratedPackage->setWeight( $package->Weight );

                        if( isset( $package->BillingWeight ) )
                        {
                            $packageBillingPackage = new Package();
                            $packageBillingPackage->setWeight( $package->BillingWeight->Weight );
                            $packageBillingPackage->setWeightUnitOfMeasure( $package->BillingWeight->UnitOfMeasurement->Code );

                            $ratedPackage->setBillingPackage( $packageBillingPackage );
                        }

                        $rateElement->addRatedPackage( $ratedPackage );
                    }
                }

                $rateResponse->addRate( $rateElement );
            }
        }

        return $rateResponse;
    }
}

?>