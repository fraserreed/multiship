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


use MultiShip\Charge\TotalCharge;

/**
 * MultiShip simple rate response object
 *
 * @author fraserreed
 */
class SimpleRate
{
    /**
     * @var string
     */
    protected $serviceCode;

    /**
     * @var string
     */
    protected $serviceDescription;

    /**
     * @var TotalCharge
     */
    protected $total;

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
}

?>