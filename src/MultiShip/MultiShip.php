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
namespace MultiShip;


use MultiShip\Configuration;
use MultiShip\Carrier\ICarrier;
use MultiShip\Carrier\UPS;
use MultiShip\Carrier\FedEx;

use MultiShip\Address\Address;
use MultiShip\Package\Package;

use MultiShip\Request\AbstractRequest;

use MultiShip\Response\Collections\Rate;

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
        if( !is_array( $options ) || empty( $options ) )
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
                    $config->setAccountNumber( $carrierConfiguration[ 'accountNumber' ] );

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

    /**
     * @return Response\Collections\Rate
     */
    public function getRates()
    {
        $response = array();

        /** @var $carrier Carrier\ICarrier */
        foreach( $this->getCarriers() as $carrier )
        {
            $response[ ] = $this->executeRequest( $carrier->getRateRequest(), $carrier );
        }

        return $this->aggregateRateResponse( $response );
    }

    /**
     * @return Response\Collections\Rate
     */
    public function getSimpleRates()
    {
        $response = array();

        /** @var $carrier Carrier\ICarrier */
        foreach( $this->getCarriers() as $carrier )
        {
            $response[ ] = $this->executeRequest( $carrier->getSimpleRateRequest(), $carrier );
        }

        return $this->aggregateRateResponse( $response );
    }

    /**
     * @param $response
     *
     * @return Response\Collections\Rate
     */
    private function aggregateRateResponse( $response )
    {
        $aggregatedResponse = new Rate();

        if( !empty( $response ) )
        {
            /** @var $responseCollection \MultiShip\Response\Collections\Rate */
            foreach( $response as $responseCollection )
            {
                //if the carrier collection returned results, add them to the aggregate collection of rates
                if( $responseCollection->getCount() > 0 )
                {
                    foreach( $responseCollection->getRates() as $rate )
                    {
                        $aggregatedResponse->addRate( $rate );
                        $aggregatedResponse->setCount( $aggregatedResponse->getCount() + 1 );
                    }
                }
            }
        }

        return $aggregatedResponse;
    }

    /**
     * @return mixed
     * @throws Exceptions\MultiShipException
     */
    public function processShipment()
    {
        $carriers = $this->getCarriers();

        if( count( $carriers ) > 1 )
            throw new MultiShipException( 'Cannot process shipment request for multiple carriers.  Submit individual requests for each carrier.' );

        //isolate carrier for request
        /** @var $carrier \MultiShip\Carrier\ICarrier */
        $carrier = $carriers[ 0 ];

        return $this->executeRequest( $carrier->getShipmentRequest(), $carrier );
    }

    /**
     * @param Request\AbstractRequest $request
     * @param Carrier\ICarrier        $carrier
     *
     * @throws Exceptions\MultiShipException
     * @return mixed
     */
    private function executeRequest( AbstractRequest $request, ICarrier $carrier )
    {
        $request->setCarrierCode( $carrier->getCarrierCode() );

        $request->setConfiguration( $carrier->getConfiguration() );

        if( !$this->getFromAddress() )
            throw new MultiShipException( 'From address must be present to execute request.' );

        $request->setFromAddress( $this->getFromAddress() );

        if( !$this->getToAddress() )
            throw new MultiShipException( 'To address must be present to execute request.' );

        $request->setToAddress( $this->getToAddress() );

        if( count( $this->getPackages() ) == 0 )
            throw new MultiShipException( 'At least one package must be present to execute request.' );

        foreach( $this->getPackages() as $package )
            $request->addPackage( $package );

        return $carrier->request( $request );
    }
}