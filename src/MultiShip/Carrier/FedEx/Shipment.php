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
use MultiShip\Charge\BaseCharge;
use MultiShip\Charge\FreightDiscountCharge;
use MultiShip\Charge\FreightCharge;
use MultiShip\Charge\SurchargeCharge;
use MultiShip\Charge\TaxCharge;
use MultiShip\Charge\NetCharge;

use MultiShip\Package\Package;

use MultiShip\Label\ShipmentLabel;

use MultiShip\Response\Collections\Shipment as ShipmentCollection;
use MultiShip\Response\Elements\ShipmentPackage;

/**
 * MultiShip shipment object
 *
 * @author fraserreed
 */
class Shipment extends AbstractShipment
{
    const STATUS_STARTED  = 'started';
    const STATUS_COMPLETE = 'complete';

    protected $operation = "ProcessShipment";

    protected $wsdl = "/Schema/Wsdl/FedEx/ShipService_v13.wsdl";

    protected $urlAction = 'ship';

    protected $shipmentStatus = null;

    protected $masterPkgTrackNum;

    protected $sequenceNumber = 0;

    protected $remainingPackages = array();

    /**
     * @var ShipmentCollection
     */
    protected $shipmentResponse;

    /**
     * @param $serviceCode
     */
    public function setServiceCode( $serviceCode )
    {
        $this->serviceCode = (string) $serviceCode;
    }

    /**
     * @return bool
     */
    public function isShipmentComplete()
    {
        if( $this->shipmentStatus !== self::STATUS_COMPLETE )
            return false;

        return true;
    }

    /**
     * @return \MultiShip\Response\Collections\Shipment
     */
    public function getShipmentResponse()
    {
        if( !$this->shipmentResponse )
            $this->shipmentResponse = new ShipmentCollection();

        return $this->shipmentResponse;
    }

    public function getRequestBody()
    {
        //mark shipment as started, in case there are multiple packages
        $this->shipmentStatus = self::STATUS_STARTED;

        $fromAddress = $this->getFromAddress();
        $toAddress   = $this->getToAddress();

        if( empty( $this->packages ) )
            throw new MultiShipException( 'At least one package must be provided for all shipment requests.' );

        //get configuration for shipping number
        $config = $this->getConfiguration();

        //if the master package has not been set yet, initialize the package list
        if( empty( $this->masterPkgTrackNum ) )
            $this->remainingPackages = $this->packages;

        //retrieve the current package for sending
        $currentPackage = array_shift( $this->remainingPackages );

        if( count( $this->remainingPackages ) == 0 )
            $this->shipmentStatus = self::STATUS_COMPLETE;

        //increment the sequence number
        $this->sequenceNumber++;

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
                'ServiceType'               => $this->getServiceCode(),
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
                'PackageCount'              => count( $this->packages ),
                'PackageDetail'             => 'INDIVIDUAL_PACKAGES',
                'RequestedPackageLineItems' => array(
                    'SequenceNumber'    => $this->sequenceNumber,
                    'GroupPackageCount' => 1, //$this->sequenceNumber,
                    'Weight'            => array(
                        'Value' => $currentPackage->getWeight(),
                        'Units' => strtoupper( $currentPackage->getWeightUnitOfMeasure( true ) )
                    ),
                    'Dimensions'        => array(
                        'Length' => $currentPackage->getLength(),
                        'Width'  => $currentPackage->getWidth(),
                        'Height' => $currentPackage->getHeight(),
                        'Units'  => strtoupper( $currentPackage->getDimensionUnitOfMeasure() )
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
                )
            )
        );

        //add master tracking information, if it is needed
        if( !empty( $this->masterPkgTrackNum ) )
            $request[ 'RequestedShipment' ][ 'MasterTrackingId' ] = $this->masterPkgTrackNum;

        return $request;
    }

    /**
     * @param $response
     *
     * @return \MultiShip\Response\Collections\Shipment
     */
    public function parseResponse( $response )
    {
        $shipmentResponse = $this->getShipmentResponse();

        $shipmentResponse->setStatusCode( $response->HighestSeverity );
        $shipmentResponse->setStatusDescription( $response->Notifications->Message );
        //$shipmentResponse->setTransactionReference( )

        if( isset( $response->CompletedShipmentDetail ) && isset( $response->CompletedShipmentDetail->CompletedPackageDetails ) )
        {
            //if there is a master package, it is a multiple package shipment
            if( isset( $response->CompletedShipmentDetail->MasterTrackingId ) )
            {
                $shipmentResponse->setMasterTrackingNumber( $response->CompletedShipmentDetail->MasterTrackingId->TrackingNumber );

                $this->masterPkgTrackNum = array(
                    'TrackingIdType' => $response->CompletedShipmentDetail->MasterTrackingId->TrackingIdType,
                    'TrackingNumber' => $response->CompletedShipmentDetail->MasterTrackingId->TrackingNumber
                );
            }

            $shipmentResponse->setCarrierCode( $this->getCarrierCode() );

            $shipmentResponse->setCount( $shipmentResponse->getCount() + 1 );
            $shipment = $response->CompletedShipmentDetail->CompletedPackageDetails;

            //shipment package
            if( isset( $shipment->PackageRating->PackageRateDetails ) )
            {
                //add package to shipment
                $shipmentResponse->addShipmentPackage( $this->processPackage( $shipment ) );
            }

            //if the shipment also include charges, set them as they show the aggregate
            if( isset( $response->CompletedShipmentDetail->ShipmentRating->ShipmentRateDetails ) )
            {
                $shipmentRateDetails = $response->CompletedShipmentDetail->ShipmentRating->ShipmentRateDetails;

                //set the overall billing package
                if( isset( $shipmentRateDetails->TotalBillingWeight ) )
                {
                    $billingPackage = new Package();
                    $billingPackage->setWeight( $shipmentRateDetails->TotalBillingWeight->Value );
                    $billingPackage->setWeightUnitOfMeasure( $shipmentRateDetails->TotalBillingWeight->Units );
                    $shipmentResponse->setBillingPackage( $billingPackage );
                }

                //base charges
                if( isset( $shipmentRateDetails->TotalBaseCharge ) )
                    $shipmentResponse->addCharge( $this->prepareCharge( new BaseCharge(), $shipmentRateDetails->TotalBaseCharge ) );

                //freight discounts
                if( isset( $shipmentRateDetails->TotalFreightDiscounts ) )
                    $shipmentResponse->addCharge( $this->prepareCharge( new FreightDiscountCharge(), $shipmentRateDetails->TotalFreightDiscounts ) );

                //freight charges
                if( isset( $shipmentRateDetails->TotalNetFreight ) )
                    $shipmentResponse->addCharge( $this->prepareCharge( new FreightCharge(), $shipmentRateDetails->TotalNetFreight ) );

                //surcharges
                if( isset( $shipmentRateDetails->TotalSurcharges ) )
                    $shipmentResponse->addCharge( $this->prepareCharge( new SurchargeCharge(), $shipmentRateDetails->TotalSurcharges ) );

                //net fedex charges
                if( isset( $shipmentRateDetails->TotalNetFedExCharge ) )
                {
                    $totalCharge = $this->prepareCharge( new TotalCharge(), $shipmentRateDetails->TotalNetFedExCharge );
                    $shipmentResponse->addCharge( $totalCharge );
                }

                //tax charges
                if( isset( $shipmentRateDetails->TotalTaxes ) )
                    $shipmentResponse->addCharge( $this->prepareCharge( new TaxCharge(), $shipmentRateDetails->TotalTaxes ) );

                //net charges
                if( isset( $shipmentRateDetails->TotalNetCharge ) )
                {
                    $netCharge = $this->prepareCharge( new NetCharge(), $shipmentRateDetails->TotalNetCharge );
                    $shipmentResponse->addCharge( $netCharge );
                }

                //set total charge
                if( !empty( $netCharge ) )
                {
                    $shipmentResponse->setTotal( $netCharge );
                }
                else if( !empty( $totalCharge ) )
                {
                    $shipmentResponse->setTotal( $totalCharge );
                }
            }
        }

        return $shipmentResponse;
    }

    /**
     * @param $shipment
     *
     * @return \MultiShip\Response\Elements\ShipmentPackage
     */
    private function processPackage( $shipment )
    {
        $shipmentPackage = new ShipmentPackage();
        $shipmentPackage->setTrackingNumber( $shipment->TrackingIds->TrackingNumber );

        $package = $shipment->PackageRating->PackageRateDetails;

        //billing weight
        if( isset( $package->BillingWeight ) )
        {
            $billingPackage = new Package();
            $billingPackage->setWeight( $package->BillingWeight->Value );
            $billingPackage->setWeightUnitOfMeasure( $package->BillingWeight->Units );
            $shipmentPackage->setBillingPackage( $billingPackage );

            //set the dimensions of the package
            $shipmentPackage->setWeight( $package->BillingWeight->Value );
            $shipmentPackage->setWeightUnitOfMeasure( $package->BillingWeight->Units );
        }

        //base charges
        if( isset( $package->BaseCharge ) )
            $shipmentPackage->addCharge( $this->prepareCharge( new BaseCharge(), $package->BaseCharge ) );

        //freight discounts
        if( isset( $package->TotalFreightDiscounts ) )
            $shipmentPackage->addCharge( $this->prepareCharge( new FreightDiscountCharge(), $package->TotalFreightDiscounts ) );

        //freight charges
        if( isset( $package->NetFreight ) )
            $shipmentPackage->addCharge( $this->prepareCharge( new FreightCharge(), $package->NetFreight ) );

        //surcharges
        if( isset( $package->TotalSurcharges ) )
            $shipmentPackage->addCharge( $this->prepareCharge( new SurchargeCharge(), $package->TotalSurcharges ) );

        //net fedex charges
        if( isset( $package->NetFedExCharge ) )
        {
            $totalCharge = $this->prepareCharge( new TotalCharge(), $package->NetFedExCharge );
            $shipmentPackage->addCharge( $totalCharge );
        }

        //tax charges
        if( isset( $package->TotalTaxes ) )
            $shipmentPackage->addCharge( $this->prepareCharge( new TaxCharge(), $package->TotalTaxes ) );

        //net charges
        if( isset( $package->NetCharge ) )
        {
            $netCharge = $this->prepareCharge( new NetCharge(), $package->NetCharge );
            $shipmentPackage->addCharge( $netCharge );
        }

        //set total charge
        if( !empty( $netCharge ) )
        {
            $shipmentPackage->setTotal( $netCharge );
        }
        else if( !empty( $totalCharge ) )
        {
            $shipmentPackage->setTotal( $totalCharge );
        }

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

        return $shipmentPackage;
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
