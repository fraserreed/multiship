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


use MultiShip\Exceptions\MultiShipException;

/**
 * MultiShip package object
 *
 * @author fraserreed
 */
class Package
{

    /**
     * @var int
     */
    protected $length;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var string
     */
    protected $dimensionUnitOfMeasure;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @var string
     */
    protected $weightUnitOfMeasure;

    /**
     * @param int $length
     */
    public function setLength( $length )
    {
        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $width
     */
    public function setWidth( $width )
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $height
     */
    public function setHeight( $height )
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $dimensionUnitOfMeasure
     *
     * @throws \MultiShip\Exceptions\MultiShipException
     */
    public function setDimensionUnitOfMeasure( $dimensionUnitOfMeasure )
    {
        //accepted dimensions
        $units = array( 'in', 'cm' );

        if( !in_array( strtolower( $dimensionUnitOfMeasure ), $units ) )
            throw new MultiShipException( 'Invalid dimension unit of measure.  Accepted values: ' . implode( $units, ',' ) );

        $this->dimensionUnitOfMeasure = $dimensionUnitOfMeasure;
    }

    /**
     * @return string
     */
    public function getDimensionUnitOfMeasure()
    {
        return $this->dimensionUnitOfMeasure;
    }

    /**
     * @return string
     */
    public function getDimensionUnitOfMeasureDescription()
    {
        $acceptedDimensionUnitOfMeasure = array(
            'in' => 'Inches',
            'cm' => 'Centimeters'
        );

        return $acceptedDimensionUnitOfMeasure[ $this->dimensionUnitOfMeasure ];
    }

    /**
     * @param int $weight
     */
    public function setWeight( $weight )
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weightUnitOfMeasure
     *
     * @throws \MultiShip\Exceptions\MultiShipException
     */
    public function setWeightUnitOfMeasure( $weightUnitOfMeasure )
    {
        //accepted weights
        $units = array( 'lb', 'lbs', 'kg', 'kgs' );

        if( !in_array( strtolower( $weightUnitOfMeasure ), $units ) )
            throw new MultiShipException( 'Invalid weight unit of measure.  Accepted values: ' . implode( $units, ',' ) );

        $this->weightUnitOfMeasure = $weightUnitOfMeasure;
    }

    /**
     * @param bool $singular
     *
     * @return string
     */
    public function getWeightUnitOfMeasure( $singular = false )
    {
        $return = $this->weightUnitOfMeasure;

        if( $singular )
        {
            switch( strtolower( $this->weightUnitOfMeasure ) )
            {
                case 'lb':
                case 'lbs':
                    $return = 'lb';
                    break;

                case 'kg':
                case 'kgs':
                    $return = 'kg';
                    break;
            }
        }
        else
        {
            switch( strtolower( $this->weightUnitOfMeasure ) )
            {
                case 'lb':
                case 'lbs':
                    $return = 'lbs';
                    break;

                case 'kg':
                case 'kgs':
                    $return = 'kgs';
                    break;
            }
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getWeightUnitOfMeasureDescription()
    {
        $acceptedWeightUnitOfMeasure = array(
            'lbs' => 'Pounds',
            'lb'  => 'Pounds',
            'kgs' => 'Kilograms',
            'kg'  => 'Kilograms'
        );

        return $acceptedWeightUnitOfMeasure[ $this->weightUnitOfMeasure ];
    }
}
