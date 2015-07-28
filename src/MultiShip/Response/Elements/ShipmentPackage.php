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
namespace MultiShip\Response\Elements;


use MultiShip\Package\Package;
use MultiShip\Charge\ICharge;
use MultiShip\Charge\TotalCharge;
use MultiShip\Label\ShipmentLabel;

/**
 * MultiShip shipment package object
 *
 * @author fraserreed
 */
class ShipmentPackage extends Package
{
    /**
     * @var string
     */
    protected $trackingNumber;

    /**
     * @var array
     */
    protected $charges;

    /**
     * @var TotalCharge
     */
    protected $total;

    /**
     * @var string
     */
    protected $packageType;

    /**
     * @var Package
     */
    protected $billingPackage;

    /**
     * @var ShipmentLabel
     */
    protected $label;

    /**
     * @param string $trackingNumber
     */
    public function setTrackingNumber( $trackingNumber )
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * @param ICharge $charge
     */
    public function addCharge( ICharge $charge )
    {
        $this->charges[ ] = $charge;
    }

    /**
     * @return array
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param \MultiShip\Charge\TotalCharge $total
     */
    public function setTotal( $total )
    {
        $this->total = $total;
    }

    /**
     * @return \MultiShip\Charge\TotalCharge
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param string $packageType
     */
    public function setPackageType( $packageType )
    {
        $this->packageType = $packageType;
    }

    /**
     * @return string
     */
    public function getPackageType()
    {
        return $this->packageType;
    }

    /**
     * @param \MultiShip\Package\Package $billingPackage
     */
    public function setBillingPackage( $billingPackage )
    {
        $this->billingPackage = $billingPackage;
    }

    /**
     * @return \MultiShip\Package\Package
     */
    public function getBillingPackage()
    {
        return $this->billingPackage;
    }

    /**
     * @param \MultiShip\Label\ShipmentLabel $label
     */
    public function setLabel( $label )
    {
        $this->label = $label;
    }

    /**
     * @return \MultiShip\Label\ShipmentLabel
     */
    public function getLabel()
    {
        return $this->label;
    }
}
