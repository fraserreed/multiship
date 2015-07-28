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

/**
 * MultiShip rated package object
 *
 * @author fraserreed
 */
class RatedPackage extends Package
{
    /**
     * @var array
     */
    protected $charges;

    /**
     * @var Package
     */
    protected $billingPackage;

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
}
