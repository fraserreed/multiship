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


/**
 * MultiShip abstract collection object
 *
 * @author fraserreed
 */
abstract class AbstractCollection implements ICollection
{

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $statusDescription;

    /**
     * @var string
     */
    protected $detail;

    /**
     * @var int
     */
    protected $count;

    /**
     * @param int $statusCode
     */
    public function setStatusCode( $statusCode )
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusDescription
     */
    public function setStatusDescription( $statusDescription )
    {
        $this->statusDescription = $statusDescription;
    }

    /**
     * @return string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * @param string $detail
     */
    public function setDetail( $detail )
    {
        $this->detail = $detail;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param int $count
     */
    public function setCount( $count )
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int) $this->count;
    }
}
