<?php

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
        $this->object->setServiceCode( 'FEDEX_EXPRESS_SAVER' );
        $this->object->setServiceDescription( 'FedEx Express Saver' );
        $this->object->setTotal( 100.99 );
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