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
namespace MultiShip\Charge;


/**
 * MultiShip tax charge object
 *
 * @author fraserreed
 */
class BaseCharge extends AbstractCharge
{

    protected $type = 'Base';

    /**
     * @return string
     */
    public function getChargeType()
    {
        return $this->type;
    }
}
