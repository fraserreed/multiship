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

use MultiShip\Response\Elements\ShipmentPackage;

use MultiShip\Label\ShipmentLabel;

use MultiShip\Package\Package;

use MultiShip\Charge\TransportationCharge;
use MultiShip\Charge\TotalCharge;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Response\Elements\ShipmentPackage
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
        $this->object->setTrackingNumber( '1Z9023492034' );
        $this->object->setTotal( 100.99 );

        $transportationCharge = new TransportationCharge();
        $transportationCharge->setCurrencyCode( 'USD' );
        $transportationCharge->setValue( 100.99 );
        $this->object->addCharge( $transportationCharge );

        $label = new ShipmentLabel();
        $label->setImageFormat( 'ZPL' );
        $label->setImageDescription( 'ZPL' );
        $label->setGraphicImage( 'zebraPrintableLabel' );
        $label->setHtmlImage( 'HTMLzebraPrintableLabel' );
        $this->object->setLabel( $label );

        $this->object->setPackageType( 'YOUR_PACKAGING' );

        $billingPackage = new Package();
        $billingPackage->setDimensionUnitOfMeasure( 'in' );
        $billingPackage->setWidth( 12 );
        $billingPackage->setLength( 12 );
        $billingPackage->setHeight( 1 );
        $billingPackage->setWeightUnitOfMeasure( 'lb' );
        $billingPackage->setWeight( 3 );
        $this->object->setBillingPackage( $billingPackage );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::setTrackingNumber
     */
    public function testSetTrackingNumber()
    {
        $this->object->setTrackingNumber( '1231278971231' );

        $this->assertNotNull( $this->object->getTrackingNumber() );
        $this->assertEquals( '1231278971231', $this->object->getTrackingNumber() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::getTrackingNumber
     */
    public function testGetTrackingNumber()
    {
        $this->assertNotNull( $this->object->getTrackingNumber() );
        $this->assertEquals( '1Z9023492034', $this->object->getTrackingNumber() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::setTotal
     */
    public function testSetTotal()
    {
        $this->object->setTotal( 55.68 );

        $this->assertNotNull( $this->object->getTotal() );
        $this->assertEquals( 55.68, $this->object->getTotal() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::getTotal
     */
    public function testGetTotal()
    {
        $this->assertNotNull( $this->object->getTotal() );
        $this->assertEquals( 100.99, $this->object->getTotal() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::addCharge
     */
    public function testAddCharge()
    {
        $totalCharge = new TotalCharge();
        $totalCharge->setCurrencyCode( 'USD' );
        $totalCharge->setValue( 16.56 );
        $this->object->addCharge( $totalCharge );

        $this->assertNotNull( $this->object->getCharges() );
        $this->assertCount( 2, $this->object->getCharges() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::getCharges
     */
    public function testGetCharges()
    {
        $this->assertNotNull( $this->object->getCharges() );
        $this->assertCount( 1, $this->object->getCharges() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::setPackageType
     */
    public function testSetPackageType()
    {
        $this->object->setPackageType( 'BUBBLE_MAILER' );

        $this->assertNotNull( $this->object->getPackageType() );
        $this->assertEquals( 'BUBBLE_MAILER', $this->object->getPackageType() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::getPackageType
     */
    public function testGetPackageType()
    {
        $this->assertNotNull( $this->object->getPackageType() );
        $this->assertEquals( 'YOUR_PACKAGING', $this->object->getPackageType() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::setBillingPackage
     */
    public function testSetBillingPackage()
    {
        $billingPackage = new Package();
        $billingPackage->setDimensionUnitOfMeasure( 'in' );
        $billingPackage->setHeight( 14 );
        $billingPackage->setLength( 16 );
        $billingPackage->setHeight( 31 );
        $billingPackage->setWeightUnitOfMeasure( 'lb' );
        $billingPackage->setWeight( 10 );
        $this->object->setBillingPackage( $billingPackage );

        $this->assertNotNull( $this->object->getBillingPackage() );
        $this->assertEquals( $billingPackage, $this->object->getBillingPackage() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::getBillingPackage
     */
    public function testGetBillingPackage()
    {
        $billingPackage = new Package();
        $billingPackage->setDimensionUnitOfMeasure( 'in' );
        $billingPackage->setWidth( 12 );
        $billingPackage->setLength( 12 );
        $billingPackage->setHeight( 1 );
        $billingPackage->setWeightUnitOfMeasure( 'lb' );
        $billingPackage->setWeight( 3 );

        $this->assertNotNull( $this->object->getBillingPackage() );
        $this->assertEquals( $billingPackage, $this->object->getBillingPackage() );
    }

    /**
     * @covers \MultiShip\Response\Elements\ShipmentPackage::setLabel
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
     * @covers \MultiShip\Response\Elements\ShipmentPackage::getLabel
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