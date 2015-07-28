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

/**
 * MultiShip request interface
 *
 * @author fraserreed
 */
interface IRequest
{
    /**
     * @return string
     */
    public function getOperation();

    /**
     * @return string
     */
    public function getWsdl();

    /**
     * @return string
     */
    public function getUrlAction();

    /**
     * @return mixed
     */
    public function getRequestBody();

    /**
     * @param $response
     *
     * @return mixed
     */
    public function parseResponse( $response );

    /**
     * @param Exception $e
     *
     * @return mixed
     */
    public function handleException( Exception $e );
}
