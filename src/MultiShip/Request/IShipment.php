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


/**
 * MultiShip shipment request interface
 *
 * @author fraserreed
 */
interface IShipment
{
    /**
     * @param string
     */
    public function setServiceCode( $serviceCode );

    /**
     * @return string
     */
    public function getServiceCode();
}
