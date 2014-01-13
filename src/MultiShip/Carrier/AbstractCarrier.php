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
namespace MultiShip\Carrier;


use Exception;

use MultiShip\Services\Soap;
use MultiShip\Configuration;
use MultiShip\Request\IRequest;

/**
 * MultiShip shipper object
 *
 * @author fraserreed
 */
abstract class AbstractCarrier implements ICarrier
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var Soap
     */
    protected $soap;

    /**
     * @var array
     */
    protected $serviceMap = array();

    public function __construct( Configuration $config )
    {
        $this->setConfiguration( $config );
    }

    /**
     * Set connection configuration
     */
    public function setConfiguration( Configuration $config )
    {
        if( !$this->config )
            $this->config = $config;
    }

    /**
     * Get connection configuration
     *
     * @return \MultiShip\Configuration
     */
    public function getConfiguration()
    {
        return $this->config;
    }

    /**
     * @param \MultiShip\Services\Soap $soap
     */
    public function setSoap( Soap $soap )
    {
        $this->soap = $soap;
    }

    /**
     * @return array
     */
    public function getServiceMap()
    {
        return $this->serviceMap;
    }

    /**
     * @return \MultiShip\Services\Soap
     */
    public function getSoap()
    {
        if( !$this->soap )
            $this->soap = new Soap();

        return $this->soap;
    }

    /**
     * @param IRequest $request
     *
     * @return mixed
     */
    public function request( IRequest $request )
    {
        try
        {
            $soapRequest = $this->getSoap();
            $soapRequest->setWsdl( $request->getWsdl() );
            $soapRequest->setEndPointUrl( $this->getEndPointUrl() . $request->getUrlAction() );
            $soapRequest->setBody( $request->getRequestBody() );

            $soapHeader = $this->getSoapHeader();

            if( $soapHeader )
                $soapRequest->setHeader( $soapHeader );

            $response = $soapRequest->call( $this->getConfiguration(), $request->getOperation() );

            return $request->parseResponse( $response );
        }
        catch( Exception $e )
        {
            return $request->handleException( $e );
        }
    }
}

?>