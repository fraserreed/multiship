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
use MultiShip\Request\AbstractRate;

use MultiShip\Response\Collections\Rate as RateCollection;
use MultiShip\Response\Elements\SimpleRate as RateElement;
use MultiShip\Charge\ICharge;
use MultiShip\Charge\TotalCharge;
use MultiShip\Charge\NetCharge;
use MultiShip\Package\Package;

use MultiShip\Exceptions\MultiShipException;

/**
 * MultiShip shipper object
 *
 * @author fraserreed
 */
class SimpleRate extends AbstractRate
{
    protected $operation = 'getRates';

    protected $wsdl = "/Schema/Wsdl/FedEx/RateService_v13.wsdl";

    protected $urlAction = 'rate';

    public function getRequestBody()
    {
        $config      = $this->getConfiguration();
        $fromAddress = $this->getFromAddress();
        $toAddress   = $this->getToAddress();

        $packages = array();

        if( empty( $this->packages ) )
            throw new MultiShipException( 'At least one package must be provided for all rate requests.' );

        /** @var $package \MultiShip\Package\Package */
        foreach( $this->packages as $package )
        {
            $packages[ ] = array(
                'SequenceNumber'    => 1,
                'GroupPackageCount' => 1,
                'Weight'            => array(
                    'Value' => $package->getWeight(),
                    'Units' => 'LB' //$package->getWeightUnitOfMeasure()
                ),
                'Dimensions'        => array(
                    'Length' => $package->getLength(),
                    'Width'  => $package->getWidth(),
                    'Height' => $package->getHeight(),
                    'Units'  => 'IN' //$package->getDimensionUnitOfMeasure()
                )
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
                'ServiceId'    => 'crs',
                'Major'        => '13',
                'Intermediate' => '0',
                'Minor'        => '0'
            ),

            'ReturnTransitAndCommit'  => true,

            'RequestedShipment'       => array(
                'DropoffType'               => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
                'ShipTimestamp'             => date( 'c' ),
                //'ServiceType'               => 'FEDEX_GROUND', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
                'PackagingType'             => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
                'TotalInsuredValue'         => array(
                    'Amount'   => 100,
                    'Currency' => 'USD'
                ),
                'Shipper'                   => array(
                    'Contact' => array(
                        'PersonName'  => $fromAddress->getName(),
                        'CompanyName' => $fromAddress->getCompany(),
                        'PhoneNumber' => $fromAddress->getPhoneNumber()
                    ),
                    'Address' => array(
                        'StreetLines'         => array(
                            $fromAddress->getLine1()
                        ),
                        'City'                => $fromAddress->getCity(),
                        'StateOrProvinceCode' => $fromAddress->getRegion(),
                        'PostalCode'          => $fromAddress->getPostalCode(),
                        'CountryCode'         => $fromAddress->getCountry()
                    )
                ),
                'Recipient'                 => array(
                    'Contact' => array(
                        'PersonName'  => $toAddress->getName(),
                        'CompanyName' => $toAddress->getCompany(),
                        'PhoneNumber' => $toAddress->getPhoneNumber()
                    ),
                    'Address' => array(
                        'StreetLines'         => array(
                            $toAddress->getLine1()
                        ),
                        'City'                => $toAddress->getCity(),
                        'StateOrProvinceCode' => $toAddress->getRegion(),
                        'PostalCode'          => $toAddress->getPostalCode(),
                        'CountryCode'         => $toAddress->getCountry(),
                        'Residential'         => false
                    )
                ),

                'ShippingChargesPayment'    => array(
                    'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
                    'Payor'       => array(
                        'ResponsibleParty' => array(
                            'AccountNumber' => $config->getAccountNumber(),
                            'CountryCode'   => 'US'
                        )
                    )
                ),

                //'RateRequestTypes'          => 'ACCOUNT',
                'RateRequestTypes'          => 'LIST',
                'PackageCount'              => count( $packages ),
                'RequestedPackageLineItems' => $packages
            )
        );

        return $request;
//        function addLabelSpecification()
//        {
//            $labelSpecification = array(
//                'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
//                'ImageType'       => 'PDF', // valid values DPL, EPL2, PDF, ZPLII and PNG
//                'LabelStockType'  => 'PAPER_7X4.75' );
//
//            return $labelSpecification;
//        }
//
//        function addSpecialServices()
//        {
//            $specialServices = array(
//                'SpecialServiceTypes' => array( 'COD' ),
//                'CodDetail'           => array(
//                    'CodCollectionAmount' => array( 'Currency' => 'USD', 'Amount' => 150 ),
//                    'CollectionType'      => 'ANY' ) // ANY, GUARANTEED_FUNDS
//            );
//
//            return $specialServices;
//        }
    }

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

                $shipmentDetail = $rate->RatedShipmentDetails[ 0 ]->ShipmentRateDetail;

                //set total charge
                if( isset( $shipmentDetail->TotalNetFedExCharge ) )
                {
                    $rateElement->setTotal( $this->prepareCharge( new TotalCharge(), $shipmentDetail->TotalNetFedExCharge ) );
                }
                elseif( isset( $shipmentDetail->TotalNetCharge ) )
                {
                    $rateElement->setTotal( $this->prepareCharge( new NetCharge(), $shipmentDetail->TotalNetCharge ) );
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

    /**
     * @param ICharge $charge
     * @param         $chargeObject
     *
     * @return ICharge
     */
    protected function prepareCharge( ICharge $charge, $chargeObject )
    {
        $charge->setCurrencyCode( $chargeObject->Currency );
        $charge->setValue( $chargeObject->Amount );

        return $charge;
    }
}

?>