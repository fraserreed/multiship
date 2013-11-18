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


use MultiShip\Response\Elements\Note;
use MultiShip\Response\Elements\SimpleRate;

/**
 * MultiShip rate collection object
 *
 * @author fraserreed
 */
class Rate extends AbstractCollection
{

    /**
     * @var array
     */
    protected $rates;

    /**
     * @var array
     */
    protected $notes;

    /**
     * @param \MultiShip\Response\Elements\SimpleRate $rate
     */
    public function addRate( SimpleRate $rate )
    {
        $this->rates[ ] = $rate;
    }

    /**
     * @param array $rates
     */
    public function setRates( $rates )
    {
        $this->rates = $rates;
    }

    /**
     * @return array
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param \MultiShip\Response\Elements\Note $note
     */
    public function addNote( Note $note )
    {
        $this->notes[ ] = $note;
    }

    /**
     * @param array $notes
     */
    public function setNotes( $notes )
    {
        $this->notes = $notes;
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }
}

?>