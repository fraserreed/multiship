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
namespace MultiShip\Tests\Response\Elements;


use MultiShip\Tests\BaseTestCase;

use MultiShip\Response\Elements\SimpleRate;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Response\Elements\SimpleRate
 */
class SimpleRateTest extends BaseTestCase
{
    /**
     * @var SimpleRate
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new SimpleRate();
        $this->object->setCarrierCode( 'FedEx' );
        $this->object->setServiceCode( 'FEDEX_EXPRESS_SAVER' );
        $this->object->setServiceDescription( 'FedEx Express Saver' );
        $this->object->setTotal( 100.99 );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::setCarrierCode
     */
    public function testSetCarrierCode()
    {
        $this->object->setCarrierCode( 'UPS' );

        $this->assertNotNull( $this->object->getCarrierCode() );
        $this->assertEquals( 'UPS', $this->object->getCarrierCode() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::getCarrierCode
     */
    public function testGetCarrierCode()
    {
        $this->assertNotNull( $this->object->getCarrierCode() );
        $this->assertEquals( 'FedEx', $this->object->getCarrierCode() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::setServiceCode
     */
    public function testSetServiceCode()
    {
        $this->object->setServiceCode( 'FEDEX_NEXT_DAY_AIR' );

        $this->assertNotNull( $this->object->getServiceCode() );
        $this->assertEquals( 'FEDEX_NEXT_DAY_AIR', $this->object->getServiceCode() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::getServiceCode
     */
    public function testGetServiceCode()
    {
        $this->assertNotNull( $this->object->getServiceCode() );
        $this->assertEquals( 'FEDEX_EXPRESS_SAVER', $this->object->getServiceCode() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::setServiceDescription
     */
    public function testSetServiceDescription()
    {
        $this->object->setServiceDescription( 'FedEx Next Day Air' );

        $this->assertNotNull( $this->object->getServiceDescription() );
        $this->assertEquals( 'FedEx Next Day Air', $this->object->getServiceDescription() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::getServiceDescription
     */
    public function testGetServiceDescription()
    {
        $this->assertNotNull( $this->object->getServiceDescription() );
        $this->assertEquals( 'FedEx Express Saver', $this->object->getServiceDescription() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::setTotal
     */
    public function testSetTotal()
    {
        $this->object->setTotal( 55.68 );

        $this->assertNotNull( $this->object->getTotal() );
        $this->assertEquals( 55.68, $this->object->getTotal() );
    }

    /**
     * @covers \MultiShip\Response\Elements\SimpleRate::getTotal
     */
    public function testGetTotal()
    {
        $this->assertNotNull( $this->object->getTotal() );
        $this->assertEquals( 100.99, $this->object->getTotal() );
    }
}

?>