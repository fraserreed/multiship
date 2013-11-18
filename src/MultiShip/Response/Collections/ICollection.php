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
namespace MultiShip\Response\Collections;


/**
 * MultiShip collection interface
 *
 * @author fraserreed
 */
interface ICollection
{
    public function setStatusCode( $statusCode );

    public function getStatusCode();

    public function setStatusDescription( $statusDescription );

    public function getStatusDescription();

    public function setCount( $count );

    public function getCount();
}

?>