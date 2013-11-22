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
namespace MultiShip\Package;


use MultiShip\Charge\ICharge;
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

?>