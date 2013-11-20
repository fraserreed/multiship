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
namespace MultiShip\Carrier\FedEx;


use MultiShip\Carrier\FedEx;

use MultiShip\Response\Collections\Rate as RateCollection;
use MultiShip\Response\Elements\Note;
use MultiShip\Response\Elements\Rate as RateElement;
use MultiShip\Charge\BaseCharge;
use MultiShip\Charge\FreightDiscountCharge;
use MultiShip\Charge\FreightCharge;
use MultiShip\Charge\SurchargeCharge;
use MultiShip\Charge\TotalCharge;
use MultiShip\Charge\TaxCharge;
use MultiShip\Charge\NetCharge;

use MultiShip\Response\Elements\DeliveryGuarantee;
use MultiShip\Package\Package;

/**
 * MultiShip shipper object
 *
 * @author fraserreed
 */
class Rate extends SimpleRate
{

    /**
     * Parse rate response, return a rate collection
     *
     * @param $response
     *
     * @return \MultiShip\Response\Collections\Rate
     */
    public function parseResponse( $response )
    {
        $rateResponse = new RateCollection();

        $rateResponse->setStatusCode( $response->HighestSeverity );
        $rateResponse->setStatusDescription( $response->Notifications->Message );

        //notes, response
        if( isset( $response->Notifications ) )
        {
            $note = new Note();
            $note->setCode( $response->Notifications->Code );
            $note->setDescription( $response->Notifications->Message );

            $rateResponse->addNote( $note );
        }

        if( isset( $response->RateReplyDetails ) && count( $response->RateReplyDetails ) > 0 )
        {
            $rateResponse->setCount( (int) count( $response->RateReplyDetails ) );

            foreach( $response->RateReplyDetails as $rate )
            {
                $rateElement = new RateElement();
                $rateElement->setCarrierCode( $this->getCarrierCode() );

                //service type
                if( isset( $rate->ServiceType ) )
                {
                    $rateElement->setServiceCode( $rate->ServiceType );
                }

                //package
                if( isset( $rate->PackagingType ) )
                {
                    $rateElement->setPackageType( $rate->PackagingType );
                }

                $shipmentDetail = $rate->RatedShipmentDetails[ 0 ]->ShipmentRateDetail;

                //billing weight
                if( isset( $shipmentDetail->TotalBillingWeight ) )
                {
                    $billingPackage = new Package();
                    $billingPackage->setWeight( $shipmentDetail->TotalBillingWeight->Value );
                    $billingPackage->setWeightUnitOfMeasure( $shipmentDetail->TotalBillingWeight->Units );

                    $rateElement->setBillingPackage( $billingPackage );
                }

                //base charges
                if( isset( $shipmentDetail->TotalBaseCharge ) )
                    $rateElement->addCharge( $this->prepareCharge( new BaseCharge(), $shipmentDetail->TotalBaseCharge ) );

                //freight discounts
                if( isset( $shipmentDetail->TotalFreightDiscounts ) )
                    $rateElement->addCharge( $this->prepareCharge( new FreightDiscountCharge(), $shipmentDetail->TotalFreightDiscounts ) );

                //freight charges
                if( isset( $shipmentDetail->NetFreight ) )
                    $rateElement->addCharge( $this->prepareCharge( new FreightCharge(), $shipmentDetail->NetFreight ) );

                //surcharges
                if( isset( $shipmentDetail->TotalSurcharges ) )
                    $rateElement->addCharge( $this->prepareCharge( new SurchargeCharge(), $shipmentDetail->TotalSurcharges ) );

                //net fedex charges
                if( isset( $shipmentDetail->TotalNetFedExCharge ) )
                {
                    $totalCharge = $this->prepareCharge( new TotalCharge(), $shipmentDetail->TotalNetFedExCharge );
                    $rateElement->addCharge( $totalCharge );
                }

                //tax charges
                if( isset( $shipmentDetail->TotalTaxes ) )
                    $rateElement->addCharge( $this->prepareCharge( new TaxCharge(), $shipmentDetail->TotalTaxes ) );

                //net charges
                if( isset( $shipmentDetail->TotalNetCharge ) )
                {
                    $netCharge = $this->prepareCharge( new NetCharge(), $shipmentDetail->TotalNetCharge );
                    $rateElement->addCharge( $netCharge );
                }

                //set total charge
                if( !empty( $totalCharge ) )
                {
                    $rateElement->setTotal( $totalCharge );
                }
                else if( !empty( $netCharge ) )
                {
                    $rateElement->setTotal( $netCharge );
                }

                //delivery time
                if( isset( $rate->TransitTime ) || isset( $rate->DeliveryDayOfWeek ) || isset( $rate->DeliveryTimestamp ) )
                {
                    $deliveryGuarantee = new DeliveryGuarantee();

                    if( isset( $rate->TransitTime ) )
                        $deliveryGuarantee->setBusinessDaysInTransit( $rate->TransitTime );

                    if( isset( $rate->DeliveryDayOfWeek ) )
                        $deliveryGuarantee->setDeliveryDay( $rate->DeliveryDayOfWeek );

                    if( isset( $rate->DeliveryTimestamp ) )
                        $deliveryGuarantee->setDeliveryTime( $rate->DeliveryTimestamp );

                    $rateElement->setDeliveryGuarantee( $deliveryGuarantee );
                }

                $rateResponse->addRate( $rateElement );
            }
        }
        else
        {
            $rateResponse->setCount( 0 );
        }

        return $rateResponse;
    }
}

?>