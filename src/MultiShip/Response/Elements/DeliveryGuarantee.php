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


/**
 * MultiShip delivery guarantee object
 *
 * @author fraserreed
 */
class DeliveryGuarantee
{
    /**
     * @var int
     */
    protected $busDaysInTransit;

    /**
     * @var string
     */
    protected $deliveryDay;

    /**
     * @var string
     */
    protected $deliveryTime;

    /**
     * @param int $busDaysInTransit
     */
    public function setBusinessDaysInTransit( $busDaysInTransit )
    {
        $this->busDaysInTransit = $busDaysInTransit;
    }

    /**
     * @return int
     */
    public function getBusinessDaysInTransit()
    {
        return $this->busDaysInTransit;
    }

    /**
     * @param string $deliveryDay
     */
    public function setDeliveryDay( $deliveryDay )
    {
        $this->deliveryDay = $deliveryDay;
    }

    /**
     * @return string
     */
    public function getDeliveryDay()
    {
        return $this->deliveryDay;
    }

    /**
     * @param string $deliveryTime
     */
    public function setDeliveryTime( $deliveryTime )
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return string
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }
}
