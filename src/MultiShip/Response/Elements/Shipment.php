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


use MultiShip\Charge\ICharge;
use MultiShip\Charge\TotalCharge;
use MultiShip\Package\Package;
use MultiShip\Package\ShipmentPackage;

/**
 * MultiShip shipment response object
 *
 * @author fraserreed
 */
class Shipment
{
    /**
     * @var string
     */
    protected $carrierCode;

    /**
     * @var string
     */
    protected $trackingNumber;

    /**
     * @var string
     */
    protected $serviceCode;

    /**
     * @var string
     */
    protected $serviceDescription;

    /**
     * @var string
     */
    protected $packageType;

    /**
     * @var Package
     */
    protected $billingPackage;

    /**
     * @var ShipmentPackage
     */
    protected $shipmentPackage;

    /**
     * @var array
     */
    protected $charges;

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
     * @param \MultiShip\Package\Package $billingPackage
     */
    public function setBillingPackage( Package $billingPackage )
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
     * @param \MultiShip\Package\ShipmentPackage $shipmentPackage
     */
    public function setShipmentPackage( ShipmentPackage $shipmentPackage )
    {
        $this->shipmentPackage = $shipmentPackage;
    }

    /**
     * @return \MultiShip\Package\ShipmentPackage
     */
    public function getShipmentPackage()
    {
        return $this->shipmentPackage;
    }

    /**
     * @param \MultiShip\Charge\ICharge $charge
     */
    public function addCharge( ICharge $charge )
    {
        $this->charges[ ] = $charge;
    }

    /**
     * @param array $charges
     */
    public function setCharges( $charges )
    {
        $this->charges = $charges;
    }

    /**
     * @return array
     */
    public function getCharges()
    {
        return $this->charges;
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
}

?>