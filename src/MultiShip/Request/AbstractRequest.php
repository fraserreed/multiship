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


use MultiShip\Carrier\ICarrier;
use MultiShip\Configuration;
use MultiShip\Address\Address;
use MultiShip\Package\Package;

use MultiShip\Exceptions\MultiShipException;

/**
 * MultiShip abstract request object
 *
 * @author fraserreed
 */
abstract class AbstractRequest
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var string
     */
    protected $operation;

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