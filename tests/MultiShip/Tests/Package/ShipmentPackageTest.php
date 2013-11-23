<?php
namespace MultiShip\Tests\Package;


use MultiShip\Tests\BaseTestCase;
use MultiShip\Package\ShipmentPackage;

use MultiShip\Charge\TotalCharge;
use MultiShip\Charge\TransportationCharge;

use MultiShip\Label\ShipmentLabel;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-05 at 23:02:52.
 */
class ShipmentPackageTest extends BaseTestCase
{
    /**
     * @var ShipmentPackage
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new ShipmentPackage();

        $this->object->setTrackingNumber( '1Z00RE7UA98A9991' );

        $totalCharge = new TotalCharge();
        $totalCharge->setCurrencyCode( 'USD' );
        $totalCharge->setValue( 72.50 );
        $this->object->addCharge( $totalCharge );

        $label = new ShipmentLabel();
        $label->setImageFormat( 'ZPL' );
        $label->setImageDescription( 'ZPL' );
        $label->setGraphicImage( 'zebraPrintableLabel' );
        $label->setHtmlImage( 'HTMLzebraPrintableLabel' );
        $this->object->setLabel( $label );
    }

    /**
     * @covers \MultiShip\Package\ShipmentPackage::setTrackingNumber
     */
    public function testSetTrackingNumber()
    {
        $this->object->setTrackingNumber( '123456789012345678' );

        $this->assertNotNull( $this->object->getTrackingNumber() );
        $this->assertEquals( '123456789012345678', $this->object->getTrackingNumber() );
    }

    /**
     * @covers \MultiShip\Package\ShipmentPackage::getTrackingNumber
     */
    public function testGetTrackingNumber()
    {
        $this->assertNotNull( $this->object->getTrackingNumber() );
        $this->assertEquals( '1Z00RE7UA98A9991', $this->object->getTrackingNumber() );
    }

    /**
     * @covers \MultiShip\Package\ShipmentPackage::addCharge
     */
    public function testAddCharge()
    {
        $transportationCharge = new TransportationCharge();
        $transportationCharge->setCurrencyCode( 'USD' );
        $transportationCharge->setValue( 12.75 );
        $this->object->addCharge( $transportationCharge );

        $charges = $this->object->getCharges();
        $this->assertNotNull( $charges );
        $this->assertCount( 2, $charges );

        /** @var $charge \MultiShip\Charge\AbstractCharge */
        foreach( $charges as $charge )
        {
            $this->assertContains( $charge->getValue(), array( 12.75, 72.50 ) );
            $this->assertEquals( 'USD', $charge->getCurrencyCode() );
            $this->assertFalse( $charge->getNegative() );
        }
    }

    /**
     * @covers \MultiShip\Package\ShipmentPackage::getCharges
     */
    public function testGetCharges()
    {
        $charges = $this->object->getCharges();
        $this->assertNotNull( $charges );
        $this->assertCount( 1, $charges );

        /** @var $charge \MultiShip\Charge\AbstractCharge */
        foreach( $charges as $charge )
        {
            $this->assertEquals( 'Total', $charge->getChargeType() );
            $this->assertEquals( 72.50, $charge->getValue() );
            $this->assertEquals( 'USD', $charge->getCurrencyCode() );
            $this->assertFalse( $charge->getNegative() );
        }
    }

    /**
     * @covers \MultiShip\Package\ShipmentPackage::setLabel
     */
    public function testSetLabel()
    {
        $label = new ShipmentLabel();
        $label->setImageFormat( 'GIF' );
        $label->setImageDescription( 'GIF' );
        $label->setGraphicImage( 'graphicImageEncoded' );
        $label->setHtmlImage( 'HTMLgraphicImageEncoded' );
        $this->object->setLabel( $label );

        $objectLabel = $this->object->getLabel();

        $this->assertInstanceOf( '\MultiShip\Label\ShipmentLabel', $objectLabel );
        $this->assertEquals( 'GIF', $objectLabel->getImageFormat() );
        $this->assertEquals( 'GIF', $objectLabel->getImageDescription() );
        $this->assertEquals( 'graphicImageEncoded', $objectLabel->getGraphicImage() );
        $this->assertEquals( 'HTMLgraphicImageEncoded', $objectLabel->getHtmlImage() );
    }

    /**
     * @covers \MultiShip\Package\ShipmentPackage::getLabel
     */
    public function testGetLabel()
    {
        $objectLabel = $this->object->getLabel();

        $this->assertInstanceOf( '\MultiShip\Label\ShipmentLabel', $objectLabel );
        $this->assertEquals( 'ZPL', $objectLabel->getImageFormat() );
        $this->assertEquals( 'ZPL', $objectLabel->getImageDescription() );
        $this->assertEquals( 'zebraPrintableLabel', $objectLabel->getGraphicImage() );
        $this->assertEquals( 'HTMLzebraPrintableLabel', $objectLabel->getHtmlImage() );
    }
}

?>