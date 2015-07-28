<?php

namespace MultiShip\Carrier\Ups\Formatters;

use MultiShip\Address\Address;


class AddressFormatter
{
    /**
     * Generate an array version of the address
     *
     * @param Address $address
     *
     * @return array
     */
    public static function format( Address $address )
    {
        return array(
            'AddressLine'       => array(
                $address->getLine1(),
                $address->getLine2(),
                $address->getLine3()
            ),
            'City'              => $address->getCity(),
            'StateProvinceCode' => $address->getRegion(),
            'PostalCode'        => $address->getPostalCode(),
            'CountryCode'       => $address->getCountry()
        );
    }
}