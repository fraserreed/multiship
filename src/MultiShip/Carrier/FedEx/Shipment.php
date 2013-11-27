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


use MultiShip\Carrier\Ups;

use MultiShip\Request\AbstractShipment;
use MultiShip\Exceptions\MultiShipException;

use MultiShip\Address\Address;

use MultiShip\Charge\ICharge;
use MultiShip\Charge\TotalCharge;
use MultiShip\Charge\TransportationCharge;
use MultiShip\Charge\ServiceCharge;
use MultiShip\Charge\BaseCharge;
use MultiShip\Charge\FreightDiscountCharge;
use MultiShip\Charge\FreightCharge;
use MultiShip\Charge\SurchargeCharge;
use MultiShip\Charge\TaxCharge;
use MultiShip\Charge\NetCharge;

use MultiShip\Package\Package;
use MultiShip\Package\ShipmentPackage;

use MultiShip\Label\ShipmentLabel;

use MultiShip\Response\Collections\Shipment as ShipmentCollection;
use MultiShip\Response\Elements\Shipment as ShipmentElement;

/**
 * MultiShip shipment object
 *
 * @author fraserreed
 */
class Shipment extends AbstractShipment
{
    protected $operation = "ProcessShipment";

    protected $wsdl = "/Schema/Wsdl/FedEx/ShipService_v13.wsdl";

    protected $urlAction = 'ship';

    public function getRequestBody()
    {
        $fromAddress = $this->getFromAddress();
        $toAddress   = $this->getToAddress();

        $packages = array();

        if( empty( $this->packages ) )
            throw new MultiShipException( 'At least one package must be provided for all shipment requests.' );

        //get configuration for shipping number
        $config = $this->getConfiguration();

        /** @var $package \MultiShip\Package\Package */
        foreach( $this->packages as $index => $package )
        {
            $packages[ ] = array(
                'SequenceNumber'    => ( $index + 1 ),
                'GroupPackageCount' => count( $this->packages ),
                'Weight'            => array(
                    'Value' => $package->getWeight(),
                    'Units' => strtoupper( $package->getWeightUnitOfMeasure( true ) )
                ),
                'Dimensions'        => array(
                    'Length' => $package->getLength(),
                    'Width'  => $package->getWidth(),
                    'Height' => $package->getHeight(),
                    'Units'  => strtoupper( $package->getDimensionUnitOfMeasure() )
                ),
                //'CustomerReferences'       => array(
                //    '0' => array(
                //        'CustomerReferenceType' => 'CUSTOMER_REFERENCE', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
                //        'Value'                 => 'GR4567892'
                //    ),
                //    '1' => array(
                //        'CustomerReferenceType' => 'INVOICE_NUMBER',
                //        'Value'                 => 'INV4567892'
                //    ),
                //    '2' => array(
                //        'CustomerReferenceType' => 'P_O_NUMBER',
                //        'Value'                 => 'PO4567892'
                //    )
                //),
                //'SpecialServicesRequested' => array(
                //    'SpecialServiceTypes' => array( 'COD' ),
                //    'CodDetail'           => array(
                //        'CodCollectionAmount' => array(
                //            'Currency' => 'USD',
                //            'Amount'   => 150
                //        ),
                //        'CollectionType'      => 'ANY' // ANY, GUARANTEED_FUNDS
                //    )
                //)
            );
        }

        $request = array(
            'WebAuthenticationDetail' => array(
                'UserCredential' => array(
                    'Key'      => $config->getAccessKey(),
                    'Password' => $config->getPassword()
                )
            ),
            'ClientDetail'            => array(
                'AccountNumber' => $config->getAccountNumber(),
                'MeterNumber'   => $config->getMeterNumber()
            ),
            'TransactionDetail'       => array(
                'CustomerTransactionId' => ' *** Rate Request v13 using PHP ***'
            ),
            'Version'                 => array(
                'ServiceId'    => 'ship',
                'Major'        => '13',
                'Intermediate' => '0',
                'Minor'        => '0'
            ),
            'RequestedShipment'       => array(
                'ShipTimestamp'             => date( 'c' ),
                // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
                'DropoffType'               => 'REGULAR_PICKUP',
                // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
                'ServiceType'               => 'FEDEX_GROUND',
                // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
                'PackagingType'             => 'YOUR_PACKAGING',
                'Shipper'                   => array(
                    'Contact' => array(
                        'PersonName'  => $fromAddress->getName(),
                        //'CompanyName' => $fromAddress->getCompany(),
                        'PhoneNumber' => $fromAddress->getPhoneNumber()
                    ),
                    'Address' => array(
                        'StreetLines'         => $this->formatStreetLines( $fromAddress ),
                        'City'                => $fromAddress->getCity(),
                        'StateOrProvinceCode' => $fromAddress->getRegion(),
                        'PostalCode'          => $fromAddress->getPostalCode(),
                        'CountryCode'         => $fromAddress->getCountry()
                    )
                ),
                'Recipient'                 => array(
                    'Contact' => array(
                        'PersonName'  => $toAddress->getName(),
                        //'CompanyName' => $toAddress->getCompany(),
                        'PhoneNumber' => $toAddress->getPhoneNumber()
                    ),
                    'Address' => array(
                        'StreetLines'         => $this->formatStreetLines( $toAddress ),
                        'City'                => $toAddress->getCity(),
                        'StateOrProvinceCode' => $toAddress->getRegion(),
                        'PostalCode'          => $toAddress->getPostalCode(),
                        'CountryCode'         => $toAddress->getCountry(),
                        'Residential'         => $toAddress->getResidentialAddress()
                    )
                ),

                'ShippingChargesPayment'    => array(
                    'PaymentType' => 'SENDER',
                    'Payor'       => array(
                        'ResponsibleParty' => array(
                            'AccountNumber' => $config->getAccountNumber(),
                            'Contact'       => null,
                            'Address'       => array(
                                'CountryCode' => $fromAddress->getCountry()
                            )
                        )
                    )
                ),
                'LabelSpecification'        => array(
                    // valid values COMMON2D, LABEL_DATA_ONLY
                    'LabelFormatType' => 'COMMON2D',
                    // valid values DPL, EPL2, PDF, ZPLII and PNG
                    'ImageType'       => 'PDF',
                    'LabelStockType'  => 'PAPER_7X4.75'
                ),

                /* Thermal Label */
                /*
                'LabelSpecification' => array(
                    'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
                    'ImageType' => 'EPL2', // valid values DPL, EPL2, PDF, ZPLII and PNG
                    'LabelStockType' => 'STOCK_4X6.75_LEADING_DOC_TAB',
                    'LabelPrintingOrientation' => 'TOP_EDGE_OF_TEXT_FIRST'
                ),
                */
                'RateRequestTypes'          => array( 'ACCOUNT' ), // valid values ACCOUNT and LIST
                'PackageCount'              => 1,
                'PackageDetail'             => 'INDIVIDUAL_PACKAGES',
                'RequestedPackageLineItems' => $packages
            )
        );

        return $request;
    }

    /**
     * @param $response
     *
     * @return \MultiShip\Response\Collections\Shipment
     */
    public function parseResponse( $response )
    {
        $shipmentResponse = new ShipmentCollection();

        $shipmentResponse->setStatusCode( $response->HighestSeverity );
        $shipmentResponse->setStatusDescription( $response->Notifications->Message );
        //$shipmentResponse->setTransactionReference( )

        if( isset( $response->CompletedShipmentDetail ) && isset( $response->CompletedShipmentDetail->CompletedPackageDetails ) )
        {
            $shipmentResponse->setCount( 1 );
            $shipment     = $response->CompletedShipmentDetail->CompletedPackageDetails;
            $shipmentRate = $response->CompletedShipmentDetail->ShipmentRating->ShipmentRateDetails;
            $package      = $shipment->PackageRating->PackageRateDetails;

            $shipmentElement = new ShipmentElement();
            $shipmentElement->setCarrierCode( $this->getCarrierCode() );

            if( isset( $shipment->TrackingIds->TrackingNumber ) )
                $shipmentElement->setTrackingNumber( $shipment->TrackingIds->TrackingNumber );

            //billing weight
            if( isset( $shipmentRate->TotalBillingWeight ) )
            {
                $billingPackage = new Package();
                $billingPackage->setWeight( $shipmentRate->TotalBillingWeight->Value );
                $billingPackage->setWeightUnitOfMeasure( $shipmentRate->TotalBillingWeight->Units );

                $shipmentElement->setBillingPackage( $billingPackage );
            }

            //base charges
            if( isset( $shipmentRate->TotalBaseCharge ) )
                $shipmentElement->addCharge( $this->prepareCharge( new BaseCharge(), $shipmentRate->TotalBaseCharge ) );

            //freight discounts
            if( isset( $shipmentRate->TotalFreightDiscounts ) )
                $shipmentElement->addCharge( $this->prepareCharge( new FreightDiscountCharge(), $shipmentRate->TotalFreightDiscounts ) );

            //freight charges
            if( isset( $shipmentRate->TotalNetFreight ) )
                $shipmentElement->addCharge( $this->prepareCharge( new FreightCharge(), $shipmentRate->TotalNetFreight ) );

            //surcharges
            if( isset( $shipmentRate->TotalSurcharges ) )
                $shipmentElement->addCharge( $this->prepareCharge( new SurchargeCharge(), $shipmentRate->TotalSurcharges ) );

            //net fedex charges
            if( isset( $shipmentRate->TotalNetFedExCharge ) )
            {
                $totalCharge = $this->prepareCharge( new TotalCharge(), $shipmentRate->TotalNetFedExCharge );
                $shipmentElement->addCharge( $totalCharge );
            }

            //tax charges
            if( isset( $shipmentRate->TotalTaxes ) )
                $shipmentElement->addCharge( $this->prepareCharge( new TaxCharge(), $shipmentRate->TotalTaxes ) );

            //net charges
            if( isset( $shipmentRate->TotalNetCharge ) )
            {
                $netCharge = $this->prepareCharge( new NetCharge(), $shipmentRate->TotalNetCharge );
                $shipmentElement->addCharge( $netCharge );
            }

            //set total charge
            if( !empty( $netCharge ) )
            {
                $shipmentElement->setTotal( $netCharge );
            }
            else if( !empty( $totalCharge ) )
            {
                $shipmentElement->setTotal( $totalCharge );
            }

            //shipment package
            if( isset( $package ) )
            {
                $shipmentPackage = new ShipmentPackage();
                $shipmentPackage->setTrackingNumber( $shipment->TrackingIds->TrackingNumber );

                //shipping label
                if( isset( $shipment->Label ) )
                {
                    $shipmentLabel = new ShipmentLabel();
                    $shipmentLabel->setImageFormat( $shipment->Label->ImageType );
                    $shipmentLabel->setImageDescription( $shipment->Label->Type );

                    switch( $shipmentLabel->getImageFormat() )
                    {
                        case 'PDF':
                            $shipmentLabel->setPdfImage( $shipment->Label->Parts->Image );
                            break;

                        case 'GIF':
                        case 'ZPL':
                            $shipmentLabel->setGraphicImage( $shipment->Label->Parts->Image );
                            break;
                    }

                    $shipmentPackage->setLabel( $shipmentLabel );
                }

                $shipmentElement->setShipmentPackage( $shipmentPackage );
            }

            $shipmentResponse->addShipment( $shipmentElement );
        }

        return $shipmentResponse;
    }

    /**
     * Format address street lines appropriately
     *
     * @param \MultiShip\Address\Address $address
     *
     * @return array
     */
    private function formatStreetLines( Address $address )
    {
        $streetLines = array();

        if( $address->getLine1() )
            $streetLines[ ] = $address->getLine1();

        if( $address->getLine2() && $address->getLine3() )
            $streetLines[ ] = $address->getLine2() . ' ' . $address->getLine3();
        else if( $address->getLine2() )
            $streetLines[ ] = $address->getLine2();
        else if( $address->getLine3() )
            $streetLines[ ] = $address->getLine3();

        return $streetLines;
    }

    /**
     * @param ICharge $charge
     * @param         $chargeObject
     *
     * @return ICharge
     */
    private function prepareCharge( ICharge $charge, $chargeObject )
    {
        $charge->setCurrencyCode( $chargeObject->Currency );
        $charge->setValue( $chargeObject->Amount );

        return $charge;
    }
}

?>
