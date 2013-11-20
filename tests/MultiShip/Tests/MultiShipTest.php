<?php
namespace MultiShip\Tests;


use MultiShip\Tests\BaseTestCase;

use MultiShip\MultiShip;
use MultiShip\Configuration;
use MultiShip\Exceptions\MultiShipException;
use MultiShip\Carrier\FedEx;
use MultiShip\Carrier\Ups;
use MultiShip\Address\Address;
use MultiShip\Package\Package;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-05 at 23:02:52.
 *
 * @covers \MultiShip\MultiShip
 * @covers \MultiShip\Request\AbstractRequest
 */
class MultiShipTest extends BaseTestCase
{
    /**
     * @var array
     */
    protected $options;

    protected function setUp()
    {
        $this->options = array(
            'ups'   => array(
                'accessKey' => "BC987DE765FG543",
                'userId'    => "multiship",
                'password'  => "SuperSecret",
                'debug'     => true
            ),
            'fedex' => array(
                'accessKey'     => "yabbaDabba600",
                'accountNumber' => "12340012",
                'meterNumber'   => "118000811",
                'password'      => "NotSoSuperSecret",
                'debug'         => true
            )
        );
    }

    /**
     * @covers \MultiShip\MultiShip::__construct
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testConstructInvalidOptions()
    {
        $options = array();

        new MultiShip( $options );
    }

    /**
     * @covers \MultiShip\MultiShip::__construct
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testConstructInvalidCarrier()
    {
        $options = array(
            'multiship' => array()
        );

        new MultiShip( $options );
    }

    /**
     * @covers \MultiShip\MultiShip::__construct
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testConstructIncorrectUpsOptions()
    {
        $options = array(
            'ups' => array(
                'accessKey' => 'empty'
            )
        );

        new MultiShip( $options );
    }

    /**
     * @covers \MultiShip\MultiShip::__construct
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testConstructIncorrectFedExOptions()
    {
        $options = array(
            'fedex' => array(
                'accessKey' => 'empty'
            )
        );

        new MultiShip( $options );
    }

    /**
     * @covers \MultiShip\MultiShip::__construct
     */
    public function testConstruct()
    {
        $object = new MultiShip( $this->options );

        $this->assertNotNull( $object );
        $this->assertInstanceOf( '\MultiShip\MultiShip', $object );
        $this->assertCount( 2, $object->getCarriers() );
    }

    /**
     * @covers \MultiShip\MultiShip::__construct
     */
    public function testConstructWithDebugOff()
    {
        $this->options[ 'ups' ][ 'debug' ]   = false;
        $this->options[ 'fedex' ][ 'debug' ] = false;

        $object = new MultiShip( $this->options );

        $this->assertNotNull( $object );
        $this->assertInstanceOf( '\MultiShip\MultiShip', $object );
        $this->assertCount( 2, $object->getCarriers() );
    }

    /**
     * @covers \MultiShip\MultiShip::getCarriers
     */
    public function testGetCarriers()
    {
        unset( $this->options[ 'fedex' ] );

        $object = new MultiShip( $this->options );

        $this->assertNotNull( $object );
        $this->assertInstanceOf( '\MultiShip\MultiShip', $object );
        $this->assertCount( 1, $object->getCarriers() );

        $config = new Configuration();
        $config->setAccessKey( $this->options[ 'ups' ][ 'accessKey' ] );
        $config->setUserId( $this->options[ 'ups' ][ 'userId' ] );
        $config->setPassword( $this->options[ 'ups' ][ 'password' ] );
        $config->setWsdl( dirname( dirname( dirname( __DIR__ ) ) ) . "/src/MultiShip/Schema/Wsdl/Ups/RateWS.wsdl" );

        if( $this->options[ 'ups' ][ 'debug' ] == true )
            $config->setEndPointUrl( 'https://wwwcie.ups.com/webservices/Rate' );
        else
            $config->setEndPointUrl( 'https://wwwcie.ups.com/webservices/Rate' );

        $carrier = new Ups( $config );

        $objectCarriers = $object->getCarriers();

        $this->assertEquals( $carrier, $objectCarriers[ 0 ] );
    }

    /**
     * @covers \MultiShip\MultiShip::setFromAddress
     * @covers \MultiShip\MultiShip::getFromAddress
     */
    public function testSetGetFromAddress()
    {
        $object = new MultiShip( $this->options );

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

        $object->setFromAddress( $from );

        $this->assertNotNull( $object->getFromAddress() );
        $this->assertEquals( $from, $object->getFromAddress() );
    }

    /**
     * @covers \MultiShip\MultiShip::setToAddress
     * @covers \MultiShip\MultiShip::getToAddress
     */
    public function testSetGetToAddress()
    {
        $object = new MultiShip( $this->options );

        $to = new Address();

        $to->setName( 'Imani Imaginarium' );
        $to->setLine1( '21 ARGONAUT SUITE B' );
        $to->setCity( 'ALISO VIEJO' );
        $to->setRegion( 'CA' );
        $to->setPostalCode( 92656 );
        $to->setCountry( 'US' );

        $object->setToAddress( $to );

        $this->assertNotNull( $object->getToAddress() );
        $this->assertEquals( $to, $object->getToAddress() );
    }

    /**
     * @covers \MultiShip\MultiShip::addPackage
     */
    public function testAddGetPackages()
    {
        $object = new MultiShip( $this->options );

        $package1 = new Package();
        $package1->setHeight( 10 );
        $package1->setWidth( 4 );
        $package1->setLength( 5 );
        $package1->setDimensionUnitOfMeasure( 'in' );
        $package1->setWeight( 1 );
        $package1->setWeightUnitOfMeasure( 'lbs' );

        $object->addPackage( $package1 );

        $package2 = new Package();
        $package2->setHeight( 3 );
        $package2->setWidth( 5 );
        $package2->setLength( 8 );
        $package2->setDimensionUnitOfMeasure( 'in' );
        $package2->setWeight( 2 );
        $package2->setWeightUnitOfMeasure( 'lbs' );

        $object->addPackage( $package2 );
    }

    /**
     * @covers \MultiShip\MultiShip::getRates
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testGetRatesFromAddressException()
    {
        unset( $this->options[ 'fedex' ] );
        $object = new MultiShip( $this->options );

        $object->getRates();
    }

    /**
     * @covers \MultiShip\MultiShip::getRates
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testGetRatesToAddressException()
    {
        unset( $this->options[ 'fedex' ] );
        $object = new MultiShip( $this->options );

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

        $object->setFromAddress( $from );

        $object->getRates();
    }

    /**
     * @covers \MultiShip\MultiShip::getRates
     * @expectedException \MultiShip\Exceptions\MultiShipException
     */
    public function testGetRatesPackageException()
    {
        unset( $this->options[ 'fedex' ] );
        $object = new MultiShip( $this->options );

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

        $object->setFromAddress( $from );

        $to = new Address();

        $to->setName( 'Imani Imaginarium' );
        $to->setLine1( '21 ARGONAUT SUITE B' );
        $to->setCity( 'ALISO VIEJO' );
        $to->setRegion( 'CA' );
        $to->setPostalCode( 92656 );
        $to->setCountry( 'US' );

        $object->setToAddress( $to );

        $object->getRates();
    }

    /**
     * @covers \MultiShip\MultiShip::getRates
     */
    public function testGetRates()
    {
        unset( $this->options[ 'fedex' ] );
        $object = new MultiShip( $this->options );

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

        $object->setFromAddress( $from );

        $to = new Address();

        $to->setName( 'Imani Imaginarium' );
        $to->setLine1( '21 ARGONAUT SUITE B' );
        $to->setCity( 'ALISO VIEJO' );
        $to->setRegion( 'CA' );
        $to->setPostalCode( 92656 );
        $to->setCountry( 'US' );

        $object->setToAddress( $to );

        $package1 = new Package();
        $package1->setHeight( 10 );
        $package1->setWidth( 4 );
        $package1->setLength( 5 );
        $package1->setDimensionUnitOfMeasure( 'in' );
        $package1->setWeight( 1 );
        $package1->setWeightUnitOfMeasure( 'lbs' );

        $object->addPackage( $package1 );

        $response = $object->getRates();

        $this->assertNotNull( $response );
        $this->assertEquals( 0, $response->getCount() );
    }

    /**
     * @covers \MultiShip\MultiShip::getSimpleRates
     */
    public function testGetSimpleRates()
    {
        unset( $this->options[ 'fedex' ] );
        $object = new MultiShip( $this->options );

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

        $object->setFromAddress( $from );

        $to = new Address();

        $to->setName( 'Imani Imaginarium' );
        $to->setLine1( '21 ARGONAUT SUITE B' );
        $to->setCity( 'ALISO VIEJO' );
        $to->setRegion( 'CA' );
        $to->setPostalCode( 92656 );
        $to->setCountry( 'US' );

        $object->setToAddress( $to );

        $package1 = new Package();
        $package1->setHeight( 10 );
        $package1->setWidth( 4 );
        $package1->setLength( 5 );
        $package1->setDimensionUnitOfMeasure( 'in' );
        $package1->setWeight( 1 );
        $package1->setWeightUnitOfMeasure( 'lbs' );

        $object->addPackage( $package1 );

        $response = $object->getSimpleRates();

        $this->assertNotNull( $response );
        $this->assertEquals( 0, $response->getCount() );
    }
}

?>