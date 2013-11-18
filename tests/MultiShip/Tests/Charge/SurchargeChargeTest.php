<?php
namespace MultiShip\Tests\Carrier;


use MultiShip\Tests\BaseTestCase;

use MultiShip\Charge\SurchargeCharge;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Charge\AbstractCharge
 * @covers MultiShip\Charge\SurchargeCharge
 */
class SurchargeChargeTest extends BaseTestCase
{

    /**
     * @var SurchargeCharge
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new SurchargeCharge();
    }

    /**
     * @covers MultiShip\Charge\SurchargeCharge::getChargeType
     */
    public function testGetChargeType()
    {
        $this->assertEquals( 'Surcharge', $this->object->getChargeType() );
    }
}

?>