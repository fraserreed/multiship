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


use MultiShip\Response\Elements\Shipment as ShipmentElement;

/**
 * MultiShip shipment collection object
 *
 * @author fraserreed
 */
class Shipment extends AbstractCollection
{

    /**
     * @var array
     */
    protected $shipments;

    /**
     * @param ShipmentElement $shipment
     */
    public function addShipment( ShipmentElement $shipment )
    {
        $this->shipments[ ] = $shipment;
    }

    /**
     * @param array $shipments
     */
    public function setShipments( $shipments )
    {
        $this->shipments = $shipments;
    }

    /**
     * @return array
     */
    public function getShipments()
    {
        return $this->shipments;
    }
}

?>
