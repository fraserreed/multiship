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
 *
 */
namespace MultiShip\Carrier;


use SoapHeader;
use MultiShip\Configuration;
use MultiShip\Request\IRequest;

use MultiShip\Request\AbstractRate;

/**
 * Shipping carrier interface
 *
 * @author fraserreed
 */
interface ICarrier
{
    /**
     * @return string
     */
    public function getCarrierCode();

    /**
     * @param \MultiShip\Configuration $config
     *
     * @return mixed
     */
    public function setConfiguration( Configuration $config );

    /**
     * @return \MultiShip\Configuration
     */
    public function getConfiguration();

    /**
     * @return SoapHeader
     */
    public function getSoapHeader();

    /**
     * @param \MultiShip\Request\IRequest $request
     *
     * @return mixed
     */
    public function request( IRequest $request );

    /**
     * @return AbstractRate
     */
    public function getRateRequest();

    /**
     * @return AbstractRate
     */
    public function getSimpleRateRequest();
}

?>