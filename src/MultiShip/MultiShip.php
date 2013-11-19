<?php

namespace MultiShip;


use MultiShip\Configuration;
use MultiShip\Carrier\ICarrier;
use MultiShip\Carrier\UPS;
use MultiShip\Carrier\FedEx;

use MultiShip\Address\Address;
use MultiShip\Package\Package;

use MultiShip\Request\AbstractRequest;

use MultiShip\Exceptions\MultiShipException;

/**
 * MultiShip object
 *
 * @author fraserreed
 */
class MultiShip
{
    /**
     * @var array
     */
    protected $carriers = array();

    /**
     * @var Address
     */
    protected $fromAddress;

    /**
     * @var Address
     */
    protected $toAddress;

    /**
     * @var array
     */
    protected $packages = array();

    /**
     * Initialize carrier configuration using passed options.
     *
     * @param array $options
     *
     * @throws Exceptions\MultiShipException
     */
    public function __construct( array $options )
    {
        if( !is_array( $options ) )
            throw new MultiShipException( 'Invalid option structure.' );

        foreach( $options as $carrier => $carrierConfiguration )
        {
            switch( strtoupper( $carrier ) )
            {
                case 'UPS':
                    //validate input
                    if( empty( $carrierConfiguration[ 'accessKey' ] ) || empty( $carrierConfiguration[ 'userId' ] ) || empty( $carrierConfiguration[ 'password' ] ) || !isset( $carrierConfiguration[ 'debug' ] ) )
                        throw new MultiShipException( 'Required parameter missing.  UPS params required are "accessKey", "userId", "password", "debug".  Please refer to the documentation for details. ' );

                    $config = new Configuration();
                    $config->setAccessKey( $carrierConfiguration[ 'accessKey' ] );
                    $config->setUserId( $carrierConfiguration[ 'userId' ] );
                    $config->setPassword( $carrierConfiguration[ 'password' ] );
                    $config->setWsdl( dirname( __DIR__ ) . "/MultiShip/Schema/Wsdl/Ups/RateWS.wsdl" );

                    if( $carrierConfiguration[ 'debug' ] == true )
                        $config->setEndPointUrl( 'https://wwwcie.ups.com/webservices/Rate' );
                    else
                        $config->setEndPointUrl( 'https://wwwcie.ups.com/webservices/Rate' );

                    $this->addCarrier( new Ups( $config ) );
                    break;

                case 'FEDEX':
                    //validate input
                    if( empty( $carrierConfiguration[ 'accessKey' ] ) || empty( $carrierConfiguration[ 'accountNumber' ] ) || empty( $carrierConfiguration[ 'meterNumber' ] ) || empty( $carrierConfiguration[ 'password' ] ) || !isset( $carrierConfiguration[ 'debug' ] ) )
                        throw new MultiShipException( 'Required parameter missing.  FedEx params required are "accessKey", "accountNumber", "meterNumber", "password", "debug".  Please refer to the documentation for details. ' );

                    $config = new Configuration();
                    $config->setAccessKey( $carrierConfiguration[ 'accessKey' ] );
                    $config->setAccountNumber( $carrierConfiguration[ 'accountNumber' ] );
                    $config->setMeterNumber( $carrierConfiguration[ 'meterNumber' ] );
                    $config->setPassword( $carrierConfiguration[ 'password' ] );
                    $config->setWsdl( dirname( __DIR__ ) . "/MultiShip/Schema/Wsdl/FedEx/RateService_v13.wsdl" );

                    if( $carrierConfiguration[ 'debug' ] == true )
                        $config->setEndPointUrl( 'https://wsbeta.fedex.com:443/web-services/rate' );
                    else
                        $config->setEndPointUrl( 'https://wsbeta.fedex.com:443/web-services/rate' );

                    $this->addCarrier( new FedEx( $config ) );
                    break;

                default:
                    throw new MultiShipException( 'Provided carrier not recognized: ' . $carrier );
                    break;
            }
        }
    }

    /**
     * Get array of array objects
     *
     * @return array
     */
    public function getCarriers()
    {
        return $this->carriers;
    }

    /**
     * Add carrier to carrier request array
     *
     * @param Carrier\ICarrier $carrier
     */
    protected function addCarrier( ICarrier $carrier )
    {
        $this->carriers[ ] = $carrier;
    }

    /**
     * @param \MultiShip\Address\Address $fromAddress
     */
    public function setFromAddress( Address $fromAddress )
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * @return \MultiShip\Address\Address
     */
    public function getFromAddress()
    {
        return $this->fromAddress;
    }

    /**
     * @param \MultiShip\Address\Address $toAddress
     */
    public function setToAddress( Address $toAddress )
    {
        $this->toAddress = $toAddress;
    }

    /**
     * @return \MultiShip\Address\Address
     */
    public function getToAddress()
    {
        return $this->toAddress;
    }

    /**
     * @param \MultiShip\Package\Package $package
     */
    public function addPackage( Package $package )
    {
        $this->packages[ ] = $package;
    }

    /**
     * @return array
     */
    protected function getPackages()
    {
        return $this->packages;
    }

    public function getRates()
    {
        $response = array();

        /** @var $carrier Carrier\ICarrier */
        foreach( $this->getCarriers() as $carrier )
        {
            $response[ ] = $this->executeRequest( $carrier->getRateRequest(), $carrier );
        }

        return $response;
    }

    /**
     * @return array
     */
    public function getSimpleRates()
    {
        $response = array();

        /** @var $carrier Carrier\ICarrier */
        foreach( $this->getCarriers() as $carrier )
        {
            $response[ ] = $this->executeRequest( $carrier->getSimpleRateRequest(), $carrier );
        }

        return $response;
    }

    /**
     * @param Request\AbstractRequest $request
     * @param Carrier\ICarrier        $carrier
     *
     * @return mixed
     */
    private function executeRequest( AbstractRequest $request, ICarrier $carrier )
    {
        $request->setConfiguration( $carrier->getConfiguration() );
        $request->setFromAddress( $this->getFromAddress() );
        $request->setToAddress( $this->getToAddress() );
        foreach( $this->getPackages() as $package )
            $request->addPackage( $package );

        return $carrier->request( $request );
    }
}