<?php
namespace MultiShip\Tests\Carrier;


use MultiShip\Tests\BaseTestCase;

use MultiShip\Charge\NetCharge;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Charge\AbstractCharge
 * @covers MultiShip\Charge\NetCharge
 */
class NetChargeTest extends BaseTestCase
{

    /**
     * @var NetCharge
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new NetCharge();
    }

    /**
     * @covers MultiShip\Charge\NetCharge::getChargeType
     */
    public function testGetChargeType()
    {
        $this->assertEquals( 'Net', $this->object->getChargeType() );
    }
}

?>