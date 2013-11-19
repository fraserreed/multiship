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

use MultiShip\Carrier\FedEx\Rate;
use MultiShip\Carrier\FedEx\SimpleRate;

/**
 * FedEx shipping carrier object
 *
 * Testing and integration URL : https://wsbeta.fedex.com:443/web-services/rate
 * Production URL : https://ws.fedex.com:443/web-services/rate
 *
 * @author fraserreed
 */
class FedEx extends AbstractCarrier
{
    /**
     * FedEx has no additional soap headers
     *
     * @return \SoapHeader|void
     */
    public function getSoapHeader()
    {
        return;
    }

    /**
     * @return FedEx\Rate
     */
    public function getRateRequest()
    {
        return new Rate();
    }

    /**
     * @return FedEx\SimpleRate
     */
    public function getSimpleRateRequest()
    {
        return new SimpleRate();
    }
}

?>