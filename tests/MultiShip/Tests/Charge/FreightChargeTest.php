<?php
namespace MultiShip\Tests\Carrier;


use MultiShip\Tests\BaseTestCase;

use MultiShip\Charge\FreightCharge;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Charge\AbstractCharge
 * @covers MultiShip\Charge\FreightCharge
 */
class FreightChargeTest extends BaseTestCase
{

    /**
     * @var FreightCharge
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new FreightCharge();
    }

    /**
     * @covers MultiShip\Charge\FreightCharge::getChargeType
     */
    public function testGetChargeType()
    {
        $this->assertEquals( 'Freight', $this->object->getChargeType() );
    }
}

?>