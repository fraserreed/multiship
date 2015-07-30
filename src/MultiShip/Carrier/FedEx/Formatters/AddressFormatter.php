<?php

namespace MultiShip\Carrier\FedEx\Formatters;

use MultiShip\Address\Address;


class AddressFormatter
{
    /**
     * Generate an array version of the address, with formatted street lines
     *
     * @param Address $address
     * @param bool    $includeResidentialFlag
     *
     * @return array
     */
    public static function format( Address $address, $includeResidentialFlag = false )
    {
        $streetLines = array();

        if( $address->getLine1() )
            $streetLines[ ] = $address->getLine1();

        if( $address->getLine2() && $address->getLine3() )
            $streetLines[ ] = $address->getLine2() . ' ' . $address->getLine3();
        else if( $address->getLine2() )
            $streetLines[ ] = $address->getLine2();
        else if( $address->getLine3() )
            $streetLines[ ] = $address->getLine3();

        $returnAddress = array(
            'StreetLines'         => $streetLines,
            'City'                => $address->getCity(),
            'StateOrProvinceCode' => $address->getRegion(),
            'PostalCode'          => $address->getPostalCode(),
            'CountryCode'         => $address->getCountry()
        );

        if( $includeResidentialFlag )
            $returnAddress[ 'Residential' ] = $address->getResidentialAddress();

        return $returnAddress;
    }
}