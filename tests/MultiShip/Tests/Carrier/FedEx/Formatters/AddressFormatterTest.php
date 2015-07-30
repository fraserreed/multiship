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
namespace MultiShip\Tests\Carrier\FedEx\Formatters;


use MultiShip\Address\Address;
use MultiShip\Carrier\FedEx\Formatters\AddressFormatter;
use MultiShip\Tests\BaseTestCase;


class AddressFormatterTest extends BaseTestCase
{
    public function testFormat()
    {
        $address = new Address();
        $address->setLine1( 'line 1 street' );
        $address->setLine2( 'apt 102' );
        $address->setLine3( 'buzzer 2' );
        $address->setCity( 'somewhereville' );
        $address->setRegion( 'new york' );
        $address->setCountry( 'usa' );
        $address->setPostalCode( '11001' );
        $address->setResidentialAddress( false );

        $response = array(
            'StreetLines'         => array(
                'line 1 street',
                'apt 102 buzzer 2',
            ),
            'City'                => 'somewhereville',
            'StateOrProvinceCode' => 'new york',
            'PostalCode'          => '11001',
            'CountryCode'         => 'usa'
        );

        $this->assertEquals( $response, AddressFormatter::format( $address ) );
    }

    public function testFormatOneLine()
    {
        $address = new Address();
        $address->setLine1( 'line 1 street' );
        $address->setCity( 'somewhereville' );
        $address->setRegion( 'new york' );
        $address->setCountry( 'usa' );
        $address->setPostalCode( '11001' );
        $address->setResidentialAddress( false );

        $response = array(
            'StreetLines'         => array(
                'line 1 street'
            ),
            'City'                => 'somewhereville',
            'StateOrProvinceCode' => 'new york',
            'PostalCode'          => '11001',
            'CountryCode'         => 'usa'
        );

        $this->assertEquals( $response, AddressFormatter::format( $address ) );
    }

    public function testFormatTwoLines()
    {
        $address = new Address();
        $address->setLine1( 'line 1 street' );
        $address->setLine2( 'apt 102' );
        $address->setCity( 'somewhereville' );
        $address->setRegion( 'new york' );
        $address->setCountry( 'usa' );
        $address->setPostalCode( '11001' );
        $address->setResidentialAddress( false );

        $response = array(
            'StreetLines'         => array(
                'line 1 street',
                'apt 102'
            ),
            'City'                => 'somewhereville',
            'StateOrProvinceCode' => 'new york',
            'PostalCode'          => '11001',
            'CountryCode'         => 'usa'
        );

        $this->assertEquals( $response, AddressFormatter::format( $address ) );

        $address->setLine2( null );
        $address->setLine3( 'buzzer 81' );

        $response[ 'StreetLines' ] = array(
            'line 1 street',
            'buzzer 81'
        );

        $this->assertEquals( $response, AddressFormatter::format( $address ) );
    }

    public function testFormatResidential()
    {
        $address = new Address();
        $address->setLine1( 'line 1 street' );
        $address->setLine2( 'apt 102' );
        $address->setLine3( 'buzzer 2' );
        $address->setCity( 'somewhereville' );
        $address->setRegion( 'new york' );
        $address->setCountry( 'usa' );
        $address->setPostalCode( '11001' );
        $address->setResidentialAddress( false );

        $response = array(
            'StreetLines'         => array(
                'line 1 street',
                'apt 102 buzzer 2',
            ),
            'City'                => 'somewhereville',
            'StateOrProvinceCode' => 'new york',
            'PostalCode'          => '11001',
            'CountryCode'         => 'usa',
            'Residential'         => false
        );

        $this->assertEquals( $response, AddressFormatter::format( $address, true ) );
    }

}