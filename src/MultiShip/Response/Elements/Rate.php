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
use MultiShip\Package\RatedPackage;
use MultiShip\Response\Elements\Note;
use MultiShip\Charge\ICharge;

/**
 * MultiShip rate response object
 *
 * @author fraserreed
 */
class Rate extends SimpleRate
{
    /**
     * @var string
     */
    protected $packageType;

    /**
     * @var Package
     */
    protected $billingPackage;

    /**
     * @var array
     */
    protected $charges;

    /**
     * @var DeliveryGuarantee
     */
    protected $deliveryGuarantee;

    /**
     * @var array
     */
    protected $ratedPackages;

    /**
     * @var array
     */
    protected $notes;

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
     * @param \MultiShip\Response\Elements\DeliveryGuarantee $deliveryGuarantee
     */
    public function setDeliveryGuarantee( DeliveryGuarantee $deliveryGuarantee )
    {
        $this->deliveryGuarantee = $deliveryGuarantee;
    }

    /**
     * @return \MultiShip\Response\Elements\DeliveryGuarantee
     */
    public function getDeliveryGuarantee()
    {
        return $this->deliveryGuarantee;
    }

    /**
     * @param \MultiShip\Package\RatedPackage $ratedPackage
     */
    public function addRatedPackage( RatedPackage $ratedPackage )
    {
        $this->ratedPackages[ ] = $ratedPackage;
    }

    /**
     * @param array $ratedPackages
     */
    public function setRatedPackages( $ratedPackages )
    {
        $this->ratedPackages = $ratedPackages;
    }

    /**
     * @return array
     */
    public function getRatedPackages()
    {
        return $this->ratedPackages;
    }

    /**
     * @param \MultiShip\Response\Elements\Note $note
     */
    public function addNote( Note $note )
    {
        $this->notes[ ] = $note;
    }

    /**
     * @param array $notes
     */
    public function setNotes( $notes )
    {
        $this->notes = $notes;
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }
}

?>