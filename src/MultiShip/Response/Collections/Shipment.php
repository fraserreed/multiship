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
namespace MultiShip\Response\Collections;


use MultiShip\Response\Elements\ShipmentPackage;
use MultiShip\Charge\TotalCharge;
use MultiShip\Package\Package;
use MultiShip\Charge\ICharge;

/**
 * MultiShip shipment collection object
 *
 * @author fraserreed
 */
class Shipment extends AbstractCollection
{

    /**
     * @var string
     */
    protected $carrierCode;

    /**
     * @var string
     */
    protected $masterTrackingNumber;

    /**
     * @var string
     */
    protected $serviceCode;

    /**
     * @var string
     */
    protected $serviceDescription;

    /**
     * @var array
     */
    protected $shipmentPackages;

    /**
     * @var Package
     */
    protected $billingPackage;

    /**
     * @var array
     */
    protected $charges = array();

    /**
     * @var TotalCharge
     */
    protected $total;

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
     * @param string $masterTrackingNumber
     */
    public function setMasterTrackingNumber( $masterTrackingNumber )
    {
        $this->masterTrackingNumber = $masterTrackingNumber;
    }

    /**
     * @return string
     */
    public function getMasterTrackingNumber()
    {
        return $this->masterTrackingNumber;
    }

    /**
     * @param string $serviceCode
     */
    public function setServiceCode( $serviceCode )
    {
        $this->serviceCode = $serviceCode;
    }

    /**
     * @return string
     */
    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    /**
     * @param string $serviceDescription
     */
    public function setServiceDescription( $serviceDescription )
    {
        $this->serviceDescription = $serviceDescription;
    }

    /**
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }

    /**
     * @param ShipmentPackage $shipmentPackage
     */
    public function addShipmentPackage( ShipmentPackage $shipmentPackage )
    {
        $this->shipmentPackages[ ] = $shipmentPackage;
    }

    /**
     * @param array $shipmentPackages
     */
    public function setShipmentPackages( $shipmentPackages )
    {
        $this->shipmentPackages = $shipmentPackages;
    }

    /**
     * @return array
     */
    public function getShipmentPackages()
    {
        return $this->shipmentPackages;
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
}

?>
