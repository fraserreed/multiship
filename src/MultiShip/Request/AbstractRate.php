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
namespace MultiShip\Request;


use Exception;

use MultiShip\Response\Collections\Rate;

/**
 * MultiShip rate object
 *
 * @author fraserreed
 */
abstract class AbstractRate extends AbstractRequest implements IRequest
{
    /**
     * Handle exception thrown from soap request
     *
     * @param $e
     *
     * @return mixed
     */
    public function handleException( Exception $e )
    {
        $rateResponse = new Rate();

        if( isset( $e->detail->Errors->ErrorDetail ) )
        {
            $rateResponse->setStatusCode( $e->detail->Errors->ErrorDetail->PrimaryErrorCode->Code );
            $rateResponse->setStatusDescription( $e->detail->Errors->ErrorDetail->PrimaryErrorCode->Description );
        }
        else
        {
            $rateResponse->setStatusCode( $e->getCode() );
            $rateResponse->setStatusDescription( $e->getMessage() );
        }

        $rateResponse->setCount( 0 );

        return $rateResponse;
    }
}

?>