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
namespace MultiShip\Tests\Carrier;


use MultiShip\Tests\BaseTestCase;

use SoapHeader;
use MultiShip\Services\Soap;
use MultiShip\Configuration;
use MultiShip\Carrier\Ups;
use MultiShip\Carrier\Ups\Rate;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-15 at 10:22:52.
 *
 * @covers MultiShip\Carrier\AbstractCarrier
 * @covers MultiShip\Carrier\Ups
 * @covers MultiShip\Request\AbstractRate
 * @covers MultiShip\Request\AbstractShipment
 */
class UpsTest extends BaseTestCase
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Ups
     */
    protected $object;

    protected function setUp()
    {
        $this->configuration = new Configuration();
        $this->configuration->setUserId( 98100 );
        $this->configuration->setPassword( 'ups_password' );
        $this->configuration->setAccessKey( 'aCC3$$' );
        $this->configuration->setWsdl( $this->getFixture( 'Wsdl/Test.wsdl', true ) );

        $this->object = new Ups( $this->configuration );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getCarrierCode
     */
    public function testGetCarrierCode()
    {
        $this->assertEquals( 'Ups', $this->object->getCarrierCode() );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getEndPointUrl
     */
    public function testGetEndPointUrlDebug()
    {
        //$this->object->setDebug( true );

        $this->assertEquals( 'https://wwwcie.ups.com/webservices/', $this->object->getEndPointUrl() );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getEndPointUrl
     */
    public function testGetEndPointUrl()
    {
        $this->assertEquals( 'https://wwwcie.ups.com/webservices/', $this->object->getEndPointUrl() );
        //$this->assertEquals( ''https://onlinetools.ups.com/webservices/'', $this->object->getEndPointUrl() );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getSoapHeader
     */
    public function testGetSoapHeader()
    {
        $expected = new SoapHeader(
            'http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0',
            'UPSSecurity',
            array(
                 'UsernameToken'      => array(
                     'Username' => $this->configuration->getUserId(),
                     'Password' => $this->configuration->getPassword()
                 ),
                 'ServiceAccessToken' => array(
                     'AccessLicenseNumber' => $this->configuration->getAccessKey()
                 )
            )
        );

        $this->assertEquals( $expected, $this->object->getSoapHeader() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::setSoap
     */
    public function testSetSoap()
    {
        $soap = new Soap();
        $soap->setOptions( array( 'testing' => true ) );

        $this->object->setSoap( $soap );

        $this->assertNotNull( $this->object->getSoap() );
        $this->assertEquals( $soap, $this->object->getSoap() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::getSoap
     */
    public function testGetSoap()
    {
        $this->assertNotNull( $this->object->getSoap() );
        $this->assertInstanceOf( '\MultiShip\Services\Soap', $this->object->getSoap() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::getServiceMap
     */
    public function testGetServiceMap()
    {
        $serviceMap = array(
            'Default' => array(
                '01' => array(
                    'name'   => 'UPS Next Day Air®',
                    'origin' => array(
                        'CA' => 'UPS Express'
                    )
                ),
                '02' => array(
                    'name'   => 'UPS Second Day Air®',
                    'origin' => array(
                        'CA' => 'UPS Worldwide Expedited'
                    )
                ),
                '03' => array(
                    'name'   => 'UPS Ground',
                    'origin' => array()
                ),
                '07' => array(
                    'name'   => 'UPS Express',
                    'origin' => array(
                        'US' => 'UPS Worldwide Express',
                        'PR' => 'UPS Worldwide Express'
                    )
                ),
                '08' => array(
                    'name'   => 'UPS Expedited',
                    'origin' => array(
                        'US' => 'UPS Worldwide Expedited',
                        'PR' => 'UPS Worldwide Expedited'
                    )
                ),
                '11' => array(
                    'name'   => 'UPS Standard',
                    'origin' => array()
                ),
                '12' => array(
                    'name'   => 'UPS Three-Day Select®',
                    'origin' => array()
                ),
                '13' => array(
                    'name'   => 'UPS Next Day Air Saver®',
                    'origin' => array(
                        'CA' => 'UPS Saver'
                    )
                ),
                '14' => array(
                    'name'   => 'UPS Next Day Air® Early A.M.',
                    'origin' => array(
                        'CA' => 'UPS Express Early A.M.'
                    )
                ),
                '54' => array(
                    'name'   => 'UPS Worldwide Express Plus',
                    'origin' => array(
                        'MX' => 'UPS Express Plus'
                    )
                ),
                '59' => array(
                    'name'   => 'UPS Second Day Air A.M.®',
                    'origin' => array()
                ),
                '65' => array(
                    'name'   => 'UPS Saver',
                    'origin' => array()
                ),
                '82' => array(
                    'name'   => 'UPS Today Standard',
                    'origin' => array()
                ),
                '83' => array(
                    'name'   => 'UPS Today Dedicated Courrier',
                    'origin' => array()
                ),
                '85' => array(
                    'name'   => 'UPS Today Express',
                    'origin' => array()
                ),
                '86' => array(
                    'name'   => 'UPS Today Express Saver',
                    'origin' => array()
                ),
                '96' => array(
                    'name'   => 'UPS Worldwide Express Freight',
                    'origin' => array()
                ),
            )
        );

        $this->assertEquals( $serviceMap, $this->object->getServiceMap() );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getRateRequest
     */
    public function testGetRateRequest()
    {
        $this->assertInstanceOf( '\MultiShip\Carrier\Ups\Rate', $this->object->getRateRequest() );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getSimpleRateRequest
     */
    public function testGetSimpleRateRequest()
    {
        $this->assertInstanceOf( '\MultiShip\Carrier\Ups\SimpleRate', $this->object->getSimpleRateRequest() );
    }

    /**
     * @covers MultiShip\Carrier\Ups::getShipmentRequest
     */
    public function testGetShipmentRequest()
    {
        $this->assertInstanceOf( '\MultiShip\Carrier\Ups\Shipment', $this->object->getShipmentRequest() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::request
     */
    public function testRequest()
    {
        $response = $this->getFixture( 'Ups/RateResponse.json' );
        $response = json_decode( $response );

        $soapRequest = $this->getMock( '\MultiShip\Services\Soap', array( 'setBody', 'setHeader', 'call' ), array() );
        $soapRequest->expects( $this->any() )->method( 'call' )->will( $this->returnValue( $response ) );
        $this->object->setSoap( $soapRequest );

        $requestBody = $this->getFixture( 'Ups/RateRequestBody.json' );

        $request = $this->getMock( '\MultiShip\Carrier\Ups\Rate', array( 'getRequestBody', 'getOperation' ), array() );
        $request->expects( $this->any() )->method( 'getRequestBody' )->will( $this->returnValue( $requestBody ) );

        $response = $this->object->request( $request );

        $this->assertNotNull( $response );
        $this->assertInstanceOf( '\MultiShip\Response\Collections\Rate', $response );
        $this->assertEquals( 7, $response->getCount() );
        $this->assertCount( 7, $response->getRates() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::request
     */
    public function testRequestException()
    {
        $exception = new \Exception( 'Error completing request', 900 );
        $soap      = $this->getMock( '\MultiShip\Services\Soap', array( 'getSoapHeader' ), array() );
        $soap->expects( $this->any() )->method( 'getSoapHeader' )->will( $this->throwException( $exception ) );
        $this->object->setSoap( new Soap() );

        $output = $this->object->request( new Rate() );

        $this->assertNotNull( $output );
        $this->assertInstanceOf( '\MultiShip\Response\Collections\Rate', $output );
        $this->assertEquals( 'From address must be provided for all shipment requests.', $output->getStatusDescription() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::request
     */
    public function testRateRequestErrorDetailException()
    {
        $exception = new \Exception( 'Error completing request', 900 );
        $soap      = $this->getMock( '\MultiShip\Services\Soap', array( 'getSoapHeader' ), array() );
        $soap->expects( $this->any() )->method( 'getSoapHeader' )->will( $this->throwException( $exception ) );
        $this->object->setSoap( new Soap() );

        $output = $this->object->request( new Rate() );

        $this->assertNotNull( $output );
        $this->assertInstanceOf( '\MultiShip\Response\Collections\Rate', $output );
        $this->assertEquals( 'From address must be provided for all shipment requests.', $output->getStatusDescription() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::request
     */
    public function testRateRequestSoapException()
    {
        $exception   = new \SoapFault( "test", 'Error completing request', 'test', json_decode( $this->getFixture( 'Ups/SoapResponseError.json' ) ) );
        $soapRequest = $this->getMock( '\MultiShip\Services\Soap', array( 'setBody', 'setHeader', 'call' ), array() );
        $soapRequest->expects( $this->any() )->method( 'call' )->will( $this->throwException( $exception ) );
        $this->object->setSoap( $soapRequest );

        $requestBody = $this->getFixture( 'Ups/RateRequestBody.json' );

        $request = $this->getMock( '\MultiShip\Carrier\Ups\Rate', array( 'getRequestBody', 'getOperation' ), array() );
        $request->expects( $this->any() )->method( 'getRequestBody' )->will( $this->returnValue( $requestBody ) );

        $output = $this->object->request( $request );

        $this->assertNotNull( $output );
        $this->assertInstanceOf( '\MultiShip\Response\Collections\Rate', $output );
        $this->assertEquals( 111, $output->getStatusCode() );
        $this->assertEquals( 'Soap Exception', $output->getStatusDescription() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::request
     */
    public function testShipmentRequestErrorDetailException()
    {
        $exception = new \Exception( 'Error completing request', 900 );
        $soap      = $this->getMock( '\MultiShip\Services\Soap', array( 'getSoapHeader' ), array() );
        $soap->expects( $this->any() )->method( 'getSoapHeader' )->will( $this->throwException( $exception ) );
        $this->object->setSoap( $soap );

        $requestBody = $this->getFixture( 'Ups/ShipmentRequestBody.json' );

        $request = $this->getMock( '\MultiShip\Carrier\Ups\Shipment', array( 'getRequestBody', 'getOperation' ), array() );
        $request->expects( $this->any() )->method( 'getRequestBody' )->will( $this->returnValue( $requestBody ) );

        $output = $this->object->request( $request );

        $this->assertNotNull( $output );
        $this->assertInstanceOf( '\MultiShip\Response\Collections\Shipment', $output );
        $this->assertEquals( 'Function ("") is not a valid method for this service', $output->getStatusDescription() );
    }

    /**
     * @covers MultiShip\Carrier\AbstractCarrier::request
     */
    public function testShipmentRequestSoapException()
    {
        $exception   = new \SoapFault( "test", 'Error completing request', 'test', json_decode( $this->getFixture( 'Ups/SoapResponseError.json' ) ) );
        $soapRequest = $this->getMock( '\MultiShip\Services\Soap', array( 'setBody', 'setHeader', 'call' ), array() );
        $soapRequest->expects( $this->any() )->method( 'call' )->will( $this->throwException( $exception ) );
        $this->object->setSoap( $soapRequest );

        $requestBody = $this->getFixture( 'Ups/ShipmentRequestBody.json' );

        $request = $this->getMock( '\MultiShip\Carrier\Ups\Shipment', array( 'getRequestBody', 'getOperation' ), array() );
        $request->expects( $this->any() )->method( 'getRequestBody' )->will( $this->returnValue( $requestBody ) );

        $output = $this->object->request( $request );

        $this->assertNotNull( $output );
        $this->assertInstanceOf( '\MultiShip\Response\Collections\Shipment', $output );
        $this->assertEquals( 111, $output->getStatusCode() );
        $this->assertEquals( 'Soap Exception', $output->getStatusDescription() );
    }
}

?>