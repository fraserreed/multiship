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
namespace MultiShip\Services;


use MultiShip\Configuration;
use MultiShip\Exceptions\MultiShipException;

use SoapClient, SoapHeader;

/**
 * MultiShip soap web services object
 *
 * @author fraserreed
 */
class Soap
{
    /**
     * @var SoapClient
     */
    protected $client;

    /**
     * @var SoapHeader
     */
    protected $header;

    /**
     * @var string
     */
    protected $wsdl;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $body;

    /**
     * @param \SoapClient $client
     */
    public function setClient( SoapClient $client )
    {
        $this->client = $client;
    }

    /**
     * @throws \MultiShip\Exceptions\MultiShipException
     * @return \SoapClient
     */
    public function getClient()
    {
        if( !$this->client )
        {
            if( !$this->getWsdl() )
                throw new MultiShipException( 'Cannot instantiate SoapClient.  Wsdl required.' );

            $this->client = new SoapClient(
                $this->getWsdl(),
                $this->getOptions()
            );
        }

        return $this->client;
    }

    /**
     * @param SoapHeader $header
     */
    public function setHeader( SoapHeader $header )
    {
        if( !$this->header )
        {
            //create soap header
            $this->header = $header;
        }
    }

    /**
     * @return \SoapHeader
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $wsdl
     */
    public function setWsdl( $wsdl )
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @return string
     */
    public function getWsdl()
    {
        return $this->wsdl;
    }

    /**
     * @param array $options
     */
    public function setOptions( $options )
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if( $this->options )
            return $this->options;

        //default options
        return array(
            'soap_version' => 'SOAP_1_1',
            'trace'        => 1
        );
    }

    /**
     * @param array $body
     */
    public function setBody( $body )
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Make a request using Soap
     *
     * @param \MultiShip\Configuration $config
     * @param                          $operation
     *
     * @return string
     */
    public function call( Configuration $config, $operation )
    {
        if( !$this->getWsdl() )
            $this->setWsdl( $config->getWsdl() );

        // initialize soap client
        $client = $this->getClient();

        //set endpoint url
        $client->__setLocation( $config->getEndPointUrl() );

        //set a soap header if there is one
        if( $this->getHeader() )
            $client->__setSoapHeaders( $this->getHeader() );

        //return response
        return $client->__soapCall( $operation, array( $this->getBody() ) );
    }
}

?>