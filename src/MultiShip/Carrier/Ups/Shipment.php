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

use MultiShip\Request\AbstractShipment;
use MultiShip\Exceptions\MultiShipException;

use MultiShip\Charge\TotalCharge;
use MultiShip\Charge\TransportationCharge;
use MultiShip\Charge\ServiceCharge;

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

    protected $wsdl = "/Schema/Wsdl/Ups/Ship.wsdl";

    protected $urlAction = 'Ship';

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
        foreach( $this->packages as $package )
        {
            $packages[ ] = array(
                'Description'   => '',
                'Packaging'     => array(
                    'Code'        => '02',
                    'Description' => 'Shipment'
                ),
                'Dimensions'    => array(
                    'UnitOfMeasurement' => array(
                        'Code'        => strtoupper( $package->getDimensionUnitOfMeasure() ),
                        'Description' => $package->getDimensionUnitOfMeasureDescription()
                    ),
                    'Length'            => (string) $package->getLength(),
                    'Width'             => (string) $package->getWidth(),
                    'Height'            => (string) $package->getHeight()
                ),
                'PackageWeight' => array(
                    'UnitOfMeasurement' => array(
                        'Code'        => strtoupper( $package->getWeightUnitOfMeasure() ),
                        'Description' => $package->getWeightUnitOfMeasureDescription()
                    ),
                    'Weight'            => (string) $package->getWeight()
                )
            );
        }

        $request = array(
            'Request'  => array(
                'RequestOption' => 'nonvalidate',
            ),
            'Shipment' => array(
                'Description'        => 'Ship WS test',
                'Shipper'            => array(
                    'Name'                    => $fromAddress->getName(),
                    'AttentionName'           => $fromAddress->getAttentionName(),
                    'TaxIdentificationNumber' => $fromAddress->getTaxIdNumber(),
                    'ShipperNumber'           => $config->getAccountNumber(),
                    'Address'                 => array(
                        'AddressLine'       => array(
                            $fromAddress->getLine1(),
                            $fromAddress->getLine2(),
                            $fromAddress->getLine3()
                        ),
                        'City'              => $fromAddress->getCity(),
                        'StateProvinceCode' => $fromAddress->getRegion(),
                        'PostalCode'        => $fromAddress->getPostalCode(),
                        'CountryCode'       => $fromAddress->getCountry()
                    ),
                    'Phone'                   => array(
                        'Number'    => $fromAddress->getPhoneNumber(),
                        'Extension' => $fromAddress->getPhoneExtension()
                    )
                ),
                'ShipTo'             => array(
                    'Name'          => $toAddress->getName(),
                    'AttentionName' => $toAddress->getAttentionName(),
                    'Address'       => array(
                        'AddressLine'                 => $toAddress->getLine1(),
                        'City'                        => $toAddress->getCity(),
                        'StateProvinceCode'           => $toAddress->getRegion(),
                        'PostalCode'                  => $toAddress->getPostalCode(),
                        'CountryCode'                 => $toAddress->getCountry(),
                        'ResidentialAddressIndicator' => $toAddress->getResidentialAddress()
                    ),
                    'Phone'         => array(
                        'Number' => $toAddress->getPhoneNumber()
                    )
                ),
                'ShipFrom'           => array(
                    'Name'          => $fromAddress->getName(),
                    'AttentionName' => $fromAddress->getAttentionName(),
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
                    ),
                    'Phone'         => array(
                        'Number' => $fromAddress->getPhoneNumber()
                    )
                ),
                'PaymentInformation' => array(
                    'ShipmentCharge' => array(
                        'Type'        => '01',
                        'BillShipper' => array(
                            'CreditCard' => array(
                                'Type'           => '06',
                                'Number'         => '4716995287640625',
                                'SecurityCode'   => '864',
                                'ExpirationDate' => '12/2013',
                                'Address'        => array(
                                    'AddressLine'       => '2010 warsaw road',
                                    'City'              => 'Roswell',
                                    'StateProvinceCode' => 'GA',
                                    'PostalCode'        => '30076',
                                    'CountryCode'       => 'US'
                                )
                            )
                        )
                    )
                ),
                'Service'            => array(
                    'Code'        => '01',
                    'Description' => 'Express'
                ),
                'Package'            => $packages,
                'LabelSpecification' => array(
                    'LabelImageFormat' => array(
                        'Code'        => 'GIF',
                        'Description' => 'GIF'
                    ),
                    'HTTPUserAgent'    => 'Mozilla/4.5'
                )
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

        $shipmentResponse->setStatusCode( $response->Response->ResponseStatus->Code );
        $shipmentResponse->setStatusDescription( $response->Response->ResponseStatus->Description );
        //$shipmentResponse->setTransactionReference( )

        if( isset( $response->ShipmentResults ) && !empty( $response->ShipmentResults->ShipmentIdentificationNumber ) )
        {

            $shipmentResponse->setCount( 1 );
            $shipment = $response->ShipmentResults;

            $shipmentElement = new ShipmentElement();
            $shipmentElement->setCarrierCode( $this->getCarrierCode() );

            $shipmentElement->setTrackingNumber( $shipment->ShipmentIdentificationNumber );

            //billing weight
            if( isset( $shipment->BillingWeight ) )
            {
                $billingPackage = new Package();
                $billingPackage->setWeight( $shipment->BillingWeight->Weight );
                $billingPackage->setWeightUnitOfMeasure( $shipment->BillingWeight->UnitOfMeasurement->Code );

                $shipmentElement->setBillingPackage( $billingPackage );
            }

            //transportation charges
            if( isset( $shipment->ShipmentCharges->TransportationCharges ) )
            {
                $transportationCharges = new TransportationCharge();
                $transportationCharges->setCurrencyCode( $shipment->ShipmentCharges->TransportationCharges->CurrencyCode );
                $transportationCharges->setValue( $shipment->ShipmentCharges->TransportationCharges->MonetaryValue );

                $shipmentElement->addCharge( $transportationCharges );
            }

            //service charges
            if( isset( $shipment->ShipmentCharges->ServiceOptionsCharges ) )
            {
                $serviceCharges = new ServiceCharge();
                $serviceCharges->setCurrencyCode( $shipment->ShipmentCharges->ServiceOptionsCharges->CurrencyCode );
                $serviceCharges->setValue( $shipment->ShipmentCharges->ServiceOptionsCharges->MonetaryValue );

                $shipmentElement->addCharge( $serviceCharges );
            }

            //total charges
            if( isset( $shipment->ShipmentCharges->TotalCharges ) )
            {
                $totalCharges = new TotalCharge();
                $totalCharges->setCurrencyCode( $shipment->ShipmentCharges->TotalCharges->CurrencyCode );
                $totalCharges->setValue( $shipment->ShipmentCharges->TotalCharges->MonetaryValue );

                $shipmentElement->setTotal( $totalCharges );
            }

            //shipment package
            if( isset( $shipment->PackageResults ) )
            {
                $shipmentPackage = new ShipmentPackage();
                $shipmentPackage->setTrackingNumber( $shipment->PackageResults->TrackingNumber );

                //service charges
                if( isset( $shipment->PackageResults->ServiceOptionsCharges ) )
                {
                    $packageServiceCharges = new ServiceCharge();
                    $packageServiceCharges->setCurrencyCode( $shipment->PackageResults->ServiceOptionsCharges->CurrencyCode );
                    $packageServiceCharges->setValue( $shipment->PackageResults->ServiceOptionsCharges->MonetaryValue );

                    $shipmentPackage->addCharge( $packageServiceCharges );
                }

                //shipping label
                if( isset( $shipment->PackageResults->ShippingLabel ) )
                {
                    $shipmentLabel = new ShipmentLabel();
                    $shipmentLabel->setImageFormat( $shipment->PackageResults->ShippingLabel->ImageFormat->Code );
                    $shipmentLabel->setImageDescription( $shipment->PackageResults->ShippingLabel->ImageFormat->Description );
                    $shipmentLabel->setGraphicImage( $shipment->PackageResults->ShippingLabel->GraphicImage );
                    $shipmentLabel->setHtmlImage( $shipment->PackageResults->ShippingLabel->HTMLImage );

                    $shipmentPackage->setLabel( $shipmentLabel );
                }

                $shipmentElement->setShipmentPackage( $shipmentPackage );
            }

            $shipmentResponse->addShipment( $shipmentElement );
        }

        return $shipmentResponse;
    }
}

?>