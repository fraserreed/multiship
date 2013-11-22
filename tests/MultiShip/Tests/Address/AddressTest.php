<?php
namespace MultiShip\Tests\Address;


use MultiShip\Tests\BaseTestCase;
use MultiShip\Address\Address;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-03 at 10:33:52.
 *
 * @covers MultiShip\Address\Address
 */
class AddressTest extends BaseTestCase
{
    /**
     * @var Address
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Address();

        $this->object->setType( 'shipping' );
        $this->object->setName( 'Imina Carr' );
        $this->object->setAttentionName( 'Mrs. Carr' );
        $this->object->setCompany( 'Shipping 123 Inc.' );
        $this->object->setNumber( 222006 );
        $this->object->setTaxIdNumber( 12345 );
        $this->object->setPhoneNumber( '209-991-0011' );
        $this->object->setPhoneExtension( '120' );
        $this->object->setLine1( 'Southam Rd' );
        $this->object->setLine2( '4 Case Court' );
        $this->object->setLine3( 'Apt 3B' );
        $this->object->setCity( 'Timonium' );
        $this->object->setRegion( 'MD' );
        $this->object->setPostalCode( 21093 );
        $this->object->setCountry( 'US' );
        $this->object->setResidentialAddress( true );
    }

    /**
     * @covers MultiShip\Address\Address::setType
     */
    public function testSetType()
    {
        $this->object->setType( 'billing' );

        $this->assertNotNull( $this->object->getType() );
        $this->assertEquals( 'billing', $this->object->getType() );
    }

    /**
     * @covers MultiShip\Address\Address::getType
     */
    public function testGetType()
    {
        $this->assertNotNull( $this->object->getType() );
        $this->assertEquals( 'shipping', $this->object->getType() );
    }

    /**
     * @covers MultiShip\Address\Address::setName
     */
    public function testSetName()
    {
        $this->object->setName( 'Idriva Vann' );

        $this->assertNotNull( $this->object->getName() );
        $this->assertEquals( 'Idriva Vann', $this->object->getName() );
    }

    /**
     * @covers MultiShip\Address\Address::getName
     */
    public function testGetName()
    {
        $this->assertNotNull( $this->object->getName() );
        $this->assertEquals( 'Imina Carr', $this->object->getName() );
    }

    /**
     * @covers MultiShip\Address\Address::setAttentionName
     */
    public function testSetAttentionName()
    {
        $this->object->setAttentionName( 'Mr. Vann' );

        $this->assertNotNull( $this->object->getAttentionName() );
        $this->assertEquals( 'Mr. Vann', $this->object->getAttentionName() );
    }

    /**
     * @covers MultiShip\Address\Address::getAttentionName
     */
    public function testGetAttentionName()
    {
        $this->assertNotNull( $this->object->getAttentionName() );
        $this->assertEquals( 'Mrs. Carr', $this->object->getAttentionName() );
    }

    /**
     * @covers MultiShip\Address\Address::setCompany
     */
    public function testSetCompany()
    {
        $this->object->setCompany( 'Receiver\'s \'R Us' );

        $this->assertNotNull( $this->object->getCompany() );
        $this->assertEquals( 'Receiver\'s \'R Us', $this->object->getCompany() );
    }

    /**
     * @covers MultiShip\Address\Address::getCompany
     */
    public function testGetCompany()
    {
        $this->assertNotNull( $this->object->getCompany() );
        $this->assertEquals( 'Shipping 123 Inc.', $this->object->getCompany() );
    }

    /**
     * @covers MultiShip\Address\Address::setNumber
     */
    public function testSetNumber()
    {
        $this->object->setNumber( 612002 );

        $this->assertNotNull( $this->object->getNumber() );
        $this->assertEquals( 612002, $this->object->getNumber() );
    }

    /**
     * @covers MultiShip\Address\Address::getNumber
     */
    public function testGetNumber()
    {
        $this->assertNotNull( $this->object->getNumber() );
        $this->assertEquals( 222006, $this->object->getNumber() );
    }

    /**
     * @covers MultiShip\Address\Address::setTaxIdNumber
     */
    public function testSetTaxIdNumber()
    {
        $this->object->setTaxIdNumber( 6120 );

        $this->assertNotNull( $this->object->getTaxIdNumber() );
        $this->assertEquals( 6120, $this->object->getTaxIdNumber() );
    }

    /**
     * @covers MultiShip\Address\Address::getTaxIdNumber
     */
    public function testGetTaxIdNumber()
    {
        $this->assertNotNull( $this->object->getTaxIdNumber() );
        $this->assertEquals( 12345, $this->object->getTaxIdNumber() );
    }

    /**
     * @covers MultiShip\Address\Address::setPhoneNumber
     */
    public function testSetPhoneNumber()
    {
        $this->object->setPhoneNumber( '210-281-1224' );

        $this->assertNotNull( $this->object->getPhoneNumber() );
        $this->assertEquals( '210-281-1224', $this->object->getPhoneNumber() );
    }

    /**
     * @covers MultiShip\Address\Address::getPhoneNumber
     */
    public function testGetPhoneNumber()
    {
        $this->assertNotNull( $this->object->getPhoneNumber() );
        $this->assertEquals( '209-991-0011', $this->object->getPhoneNumber() );
    }

    /**
     * @covers MultiShip\Address\Address::setPhoneExtension
     */
    public function testSetPhoneExtension()
    {
        $this->object->setPhoneExtension( '210' );

        $this->assertNotNull( $this->object->getPhoneExtension() );
        $this->assertEquals( '210', $this->object->getPhoneExtension() );
    }

    /**
     * @covers MultiShip\Address\Address::getPhoneExtension
     */
    public function testGetPhoneExtension()
    {
        $this->assertNotNull( $this->object->getPhoneExtension() );
        $this->assertEquals( '120', $this->object->getPhoneExtension() );
    }

    /**
     * @covers MultiShip\Address\Address::setLine1
     */
    public function testSetLine1()
    {
        $this->object->setLine1( '123 Main St.' );

        $this->assertNotNull( $this->object->getLine1() );
        $this->assertEquals( '123 Main St.', $this->object->getLine1() );
    }

    /**
     * @covers MultiShip\Address\Address::getLine1
     */
    public function testGetLine1()
    {
        $this->assertNotNull( $this->object->getLine1() );
        $this->assertEquals( 'Southam Rd', $this->object->getLine1() );
    }

    /**
     * @covers MultiShip\Address\Address::setLine2
     */
    public function testSetLine2()
    {
        $this->object->setLine2( 'RR 6' );

        $this->assertNotNull( $this->object->getLine2() );
        $this->assertEquals( 'RR 6', $this->object->getLine2() );
    }

    /**
     * @covers MultiShip\Address\Address::getLine2
     */
    public function testGetLine2()
    {
        $this->assertNotNull( $this->object->getLine2() );
        $this->assertEquals( '4 Case Court', $this->object->getLine2() );
    }

    /**
     * @covers MultiShip\Address\Address::setLine3
     */
    public function testSetLine3()
    {
        $this->object->setLine3( 'Unit 2001' );

        $this->assertNotNull( $this->object->getLine3() );
        $this->assertEquals( 'Unit 2001', $this->object->getLine3() );
    }

    /**
     * @covers MultiShip\Address\Address::getLine3
     */
    public function testGetLine3()
    {
        $this->assertNotNull( $this->object->getLine3() );
        $this->assertEquals( 'Apt 3B', $this->object->getLine3() );
    }

    /**
     * @covers MultiShip\Address\Address::setCity
     */
    public function testSetCity()
    {
        $this->object->setCity( 'Shippingsville' );

        $this->assertNotNull( $this->object->getCity() );
        $this->assertEquals( 'Shippingsville', $this->object->getCity() );
    }

    /**
     * @covers MultiShip\Address\Address::getCity
     */
    public function testGetCity()
    {
        $this->assertNotNull( $this->object->getCity() );
        $this->assertEquals( 'Timonium', $this->object->getCity() );
    }

    /**
     * @covers MultiShip\Address\Address::setRegion
     */
    public function testSetRegion()
    {
        $this->object->setRegion( 'ON' );

        $this->assertNotNull( $this->object->getRegion() );
        $this->assertEquals( 'ON', $this->object->getRegion() );
    }

    /**
     * @covers MultiShip\Address\Address::getRegion
     */
    public function testGetRegion()
    {
        $this->assertNotNull( $this->object->getRegion() );
        $this->assertEquals( 'MD', $this->object->getRegion() );
    }

    /**
     * @covers MultiShip\Address\Address::setPostalCode
     */
    public function testSetPostalCode()
    {
        $this->object->setPostalCode( 'K2A1Y1' );

        $this->assertNotNull( $this->object->getPostalCode() );
        $this->assertEquals( 'K2A1Y1', $this->object->getPostalCode() );
    }

    /**
     * @covers MultiShip\Address\Address::getPostalCode
     */
    public function testGetPostalCode()
    {
        $this->assertNotNull( $this->object->getPostalCode() );
        $this->assertEquals( 21093, $this->object->getPostalCode() );
    }

    /**
     * @covers MultiShip\Address\Address::setCountry
     */
    public function testSetCountry()
    {
        $this->object->setCountry( 'CA' );

        $this->assertNotNull( $this->object->getCountry() );
        $this->assertEquals( 'CA', $this->object->getCountry() );
    }

    /**
     * @covers MultiShip\Address\Address::getCountry
     */
    public function testGetCountry()
    {
        $this->assertNotNull( $this->object->getCountry() );
        $this->assertEquals( 'US', $this->object->getCountry() );
    }

    /**
     * @covers MultiShip\Address\Address::setResidentialAddress
     */
    public function testSetResidentialAddress()
    {
        $this->object->setResidentialAddress( false );

        $this->assertNotNull( $this->object->getResidentialAddress() );
        $this->assertFalse( $this->object->getResidentialAddress() );
    }

    /**
     * @covers MultiShip\Address\Address::getResidentialAddress
     */
    public function testGetResidentialAddress()
    {
        $this->assertNotNull( $this->object->getResidentialAddress() );
        $this->assertTrue( $this->object->getResidentialAddress() );
    }
}
