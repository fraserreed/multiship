<?php

namespace MultiShip\Tests\Carrier\Ups;


use MultiShip\Tests\BaseTestCase;

use MultiShip\Configuration;
use MultiShip\Carrier\Ups;
use MultiShip\Carrier\Ups\SimpleRate;

use MultiShip\Address\Address;
use MultiShip\Package\Package;

use MultiShip\Exceptions\MultiShipException;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Carrier\AbstractCarrier
 * @covers MultiShip\Carrier\Ups\SimpleRate
 */
class SimpleRateTest extends BaseTestCase
{
    /**
     * @var SimpleRate
     */
    protected $object;

    protected function setUp()
    {
        $configuration = new Configuration();
        $configuration->setUserId( 98100 );
        $configuration->setPassword( 'ups_password' );
        $configuration->setAccessKey( 'aCC3$$' );

        $this->object = new SimpleRate();
        $this->object->setConfiguration( $configuration );
    }

    /**
     * @covers \MultiShip\Carrier\Ups\SimpleRate::getRequestBody
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testGetRequestBodyNoFromAddress()
    {
        $this->object->getRequestBody();
    }

    /**
     * @covers \MultiShip\Carrier\Ups\SimpleRate::getRequestBody
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testGetRequestBodyNoToAddress()
    {
        $from = new Address();
        $from->setName( 'Imani Carr' );
        $from->setNumber( 222006 );
        $from->setLine1( 'Southam Rd' );
        $from->setLine2( '4 Case Cour' );
        $from->setLine3( 'Apt 3B' );
        $from->setCity( 'Timonium' );
        $from->setRegion( 'MD' );
        $from->setPostalCode( 21093 );
        $from->setCountry( 'US' );

        $this->object->setFromAddress( $from );

        $this->object->getRequestBody();
    }

    /**
     * @covers \MultiShip\Carrier\Ups\SimpleRate::getRequestBody
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testGetRequestBodyNoPackages()
    {
        $to = new Address();
        $to->setName( 'Imani Imaginarium' );
        $to->setLine1( '21 ARGONAUT SUITE B' );
        $to->setCity( 'ALISO VIEJO' );
        $to->setRegion( 'CA' );
        $to->setPostalCode( 92656 );
        $to->setCountry( 'US' );

        $from = new Address();
        $from->setName( 'Imani Carr' );
        $from->setNumber( 222006 );
        $from->setLine1( 'Southam Rd' );
        $from->setLine2( '4 Case Cour' );
        $from->setLine3( 'Apt 3B' );
        $from->setCity( 'Timonium' );
        $from->setRegion( 'MD' );
        $from->setPostalCode( 21093 );
        $from->setCountry( 'US' );

        $this->object->setToAddress( $to );
        $this->object->setFromAddress( $from );

        $this->object->getRequestBody();
    }

    /**
     * @covers \MultiShip\Carrier\Ups\SimpleRate::getRequestBody
     */
    public function testGetRequestBody()
    {
        $to = new Address();
        $to->setName( 'Imani Imaginarium' );
        $to->setLine1( '21 ARGONAUT SUITE B' );
        $to->setCity( 'ALISO VIEJO' );
        $to->setRegion( 'CA' );
        $to->setPostalCode( 92656 );
        $to->setCountry( 'US' );

        $from = new Address();
        $from->setName( 'Imani Carr' );
        $from->setNumber( 222006 );
        $from->setLine1( 'Southam Rd' );
        $from->setLine2( '4 Case Cour' );
        $from->setLine3( 'Apt 3B' );
        $from->setCity( 'Timonium' );
        $from->setRegion( 'MD' );
        $from->setPostalCode( 21093 );
        $from->setCountry( 'US' );

        $this->object->setToAddress( $to );
        $this->object->setFromAddress( $from );

        $package1 = new Package();
        $package1->setHeight( 10 );
        $package1->setWidth( 4 );
        $package1->setLength( 5 );
        $package1->setDimensionUnitOfMeasure( 'in' );
        $package1->setWeight( 1 );
        $package1->setWeightUnitOfMeasure( 'lbs' );

        $this->object->addPackage( $package1 );

        $package2 = new Package();
        $package2->setHeight( 3 );
        $package2->setWidth( 5 );
        $package2->setLength( 8 );
        $package2->setDimensionUnitOfMeasure( 'in' );
        $package2->setWeight( 2 );
        $package2->setWeightUnitOfMeasure( 'lbs' );

        $this->object->addPackage( $package2 );

        $body = $this->object->getRequestBody();

        $data = json_decode( $this->getFixture( 'Ups/RateRequestBody.json' ), true );

        $this->assertEquals( $data, $body );
    }

    /**
     * @covers \MultiShip\Carrier\Ups\SimpleRate::parseResponse
     */
    public function testParseResponse()
    {
        $data     = $this->getFixture( 'Ups/RateResponse.json' );
        $response = json_decode( $data, false );

        $actual = $this->object->parseResponse( $response );

        $this->assertEmpty( $actual->getNotes() );
        $this->assertCount( 7, $actual->getRates() );

        /** @var $rate \MultiShip\Response\Elements\Rate */
        foreach( $actual->getRates() as $rate )
        {
            $this->assertContains( $rate->getTotal()->getValue(), array( 16.64, 40.34, 60.78, 52.92, 119.00, 197.14, 130.84 ) );
            $this->assertContains( $rate->getServiceCode(), array( '03', '12', '59', '02', '13', '14', '01' ) );
        }

        $this->assertEquals( 1, $actual->getStatusCode() );
        $this->assertEquals( 'Success', $actual->getStatusDescription() );
        $this->assertEquals( 7, $actual->getCount() );
    }

    /**
     * @covers \MultiShip\Carrier\Ups\SimpleRate::parseResponse
     */
    public function testParseResponseEmpty()
    {
        $data     = $this->getFixture( 'Ups/RateResponseEmpty.json' );
        $response = json_decode( $data, false );

        $actual = $this->object->parseResponse( $response );

        $this->assertEmpty( $actual->getNotes() );
        $this->assertEmpty( $actual->getRates() );

        $this->assertEquals( 1, $actual->getStatusCode() );
        $this->assertEquals( 'Success', $actual->getStatusDescription() );
        $this->assertEquals( 0, $actual->getCount() );
    }
}

?>