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


use MultiShip\Configuration;
use MultiShip\Address\Address;
use MultiShip\Package\Package;

use MultiShip\Exceptions\MultiShipException;

/**
 * MultiShip abstract request object
 *
 * @author fraserreed
 */
abstract class AbstractRequest implements IRequest
{
    const DEFAULT_TYPE = 'Default';

    /**
     * @var
     */
    protected $type;

    /**
     * @var string
     */
    protected $carrierCode;

    /**
     * @var array
     */
    protected $serviceMap;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var string
     */
    protected $operation;

    /**
     * @var string
     */
    protected $wsdl;

    /**
     * @var string
     */
    protected $urlAction;

    /**
     * @var Address
     */
    protected $shipFrom;

    /**
     * @var Address
     */
    protected $shipTo;

    /**
     * @var array
     */
    protected $packages = array();

    /**
     * @return string
     */
    public function getType()
    {
        return (string) $this->type;
    }

    /**
     * @param string $carrierCode
     */
    public function setCarrierCode( $carrierCode )
    {
        $this->carrierCode = $carrierCode;
    }

    /**
     * @return string
     */
    public function getCarrierCode()
    {
        return $this->carrierCode;
    }

    /**
     * @param array $serviceMap
     */
    public function setServiceMap( $serviceMap )
    {
        $this->serviceMap = $serviceMap;
    }

    /**
     * @param $serviceCode
     *
     * @return string|null
     */
    public function getServiceName( $serviceCode )
    {
        if( isset( $this->serviceMap[ $this->getType() ][ $serviceCode ][ 'name' ] ) )
            return $this->serviceMap[ $this->getType() ][ $serviceCode ][ 'name' ];
        elseif( isset( $this->serviceMap[ self::DEFAULT_TYPE ][ $serviceCode ][ 'name' ] ) )
        {

            return $this->serviceMap[ self::DEFAULT_TYPE ][ $serviceCode ][ 'name' ];
        }


        return null;
    }

    /**
     * @param \MultiShip\Configuration $configuration
     */
    public function setConfiguration( $configuration )
    {
        $this->configuration = $configuration;
    }

    /**
     * @return \MultiShip\Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return string
     */
    public function getWsdl()
    {
        return $this->wsdl;
    }

    /**
     * @return string
     */
    public function getUrlAction()
    {
        return $this->urlAction;
    }

    /**
     * @param \MultiShip\Address\Address $shipFrom
     */
    public function setFromAddress( Address $shipFrom )
    {
        $this->shipFrom = $shipFrom;
    }

    /**
     * @throws \MultiShip\Exceptions\MultiShipException
     * @return \MultiShip\Address\Address
     */
    public function getFromAddress()
    {
        if( empty( $this->shipFrom ) || !( $this->shipFrom instanceof Address ) )
            throw new MultiShipException( 'From address must be provided for all shipment requests.' );

        return $this->shipFrom;
    }

    /**
     * @param \MultiShip\Address\Address $shipTo
     */
    public function setToAddress( Address $shipTo )
    {
        $this->shipTo = $shipTo;
    }

    /**
     * @throws \MultiShip\Exceptions\MultiShipException
     * @return \MultiShip\Address\Address
     */
    public function getToAddress()
    {
        if( empty( $this->shipTo ) || !( $this->shipTo instanceof Address ) )
            throw new MultiShipException( 'To address must be provided for all shipment requests.' );

        return $this->shipTo;
    }

    /**
     * @param \MultiShip\Package\Package $package
     */
    public function addPackage( Package $package )
    {
        $this->packages[ ] = $package;
    }
}

?>