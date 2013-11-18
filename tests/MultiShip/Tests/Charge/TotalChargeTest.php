<?php
namespace MultiShip\Tests\Carrier;


use MultiShip\Tests\BaseTestCase;

use MultiShip\Charge\TotalCharge;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Charge\AbstractCharge
 * @covers MultiShip\Charge\TotalCharge
 */
class TotalChargeTest extends BaseTestCase
{

    /**
     * @var TotalCharge
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new TotalCharge();
    }

    /**
     * @covers MultiShip\Charge\TotalCharge::getChargeType
     */
    public function testGetChargeType()
    {
        $this->assertEquals( 'Total', $this->object->getChargeType() );
    }
}

?>