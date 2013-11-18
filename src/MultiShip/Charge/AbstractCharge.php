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
namespace MultiShip\Charge;


/**
 * MultiShip abstract charge response object
 *
 * @author fraserreed
 */
abstract class AbstractCharge implements ICharge
{
    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var float
     */
    protected $value;

    /**
     * @var boolean
     */
    protected $negative = false;

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode( $currencyCode )
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param float $value
     */
    public function setValue( $value )
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param boolean $negative
     */
    public function setNegative( $negative )
    {
        $this->negative = $negative;
    }

    /**
     * @return boolean
     */
    public function getNegative()
    {
        return $this->negative;
    }
}

?>