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

use MultiShip\Response\Elements\DeliveryGuarantee;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Response\Elements\DeliveryGuarantee
 */
class DeliveryGuaranteeTest extends BaseTestCase
{
    /**
     * @var DeliveryGuarantee
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new DeliveryGuarantee();
        $this->object->setBusinessDaysInTransit( 4 );
        $this->object->setDeliveryDay( 'Monday' );
        $this->object->setDeliveryTime( '12:00' );
    }

    /**
     * @covers \MultiShip\Response\Elements\DeliveryGuarantee::setBusinessDaysInTransit
     */
    public function testSetBusinessDaysInTransit()
    {
        $this->object->setBusinessDaysInTransit( 'Five.' );

        $this->assertNotNull( $this->object->getBusinessDaysInTransit() );
        $this->assertEquals( 'Five.', $this->object->getBusinessDaysInTransit() );
    }

    /**
     * @covers \MultiShip\Response\Elements\DeliveryGuarantee::getBusinessDaysInTransit
     */
    public function testGetBusinessDaysInTransit()
    {
        $this->assertNotNull( $this->object->getBusinessDaysInTransit() );
        $this->assertEquals( 4, $this->object->getBusinessDaysInTransit() );
    }

    /**
     * @covers \MultiShip\Response\Elements\DeliveryGuarantee::setDeliveryDay
     */
    public function testSetDeliveryDay()
    {
        $this->object->setDeliveryDay( 'THUR' );

        $this->assertNotNull( $this->object->getDeliveryDay() );
        $this->assertEquals( 'THUR', $this->object->getDeliveryDay() );
    }

    /**
     * @covers \MultiShip\Response\Elements\DeliveryGuarantee::getDeliveryDay
     */
    public function testGetDeliveryDay()
    {
        $this->assertNotNull( $this->object->getDeliveryDay() );
        $this->assertEquals( 'Monday', $this->object->getDeliveryDay() );
    }

    /**
     * @covers \MultiShip\Response\Elements\DeliveryGuarantee::setDeliveryTime
     */
    public function testSetDeliveryTime()
    {
        $this->object->setDeliveryTime( '09:30 PM' );

        $this->assertNotNull( $this->object->getDeliveryTime() );
        $this->assertEquals( '09:30 PM', $this->object->getDeliveryTime() );
    }

    /**
     * @covers \MultiShip\Response\Elements\DeliveryGuarantee::getDeliveryTime
     */
    public function testGetDeliveryTime()
    {
        $this->assertNotNull( $this->object->getDeliveryTime() );
        $this->assertEquals( '12:00', $this->object->getDeliveryTime() );
    }
}

?>