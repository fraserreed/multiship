.. index::
   single: Rate Requests

Rate Requests
=============

getRates
--------

Request
~~~~~~~

.. code-block:: php

    # populate from address
    $from = new Address();

    $from->setName( 'Imani Carr' );
    $from->setNumber( 222006 );
    $from->setLine1( 'Southam Rd' );
    $from->setLine2( '4 Case Cour' );
    $from->setLine3( 'Apt 3B' );
    $from->setCity( 'Timonium' );
    $from->setRegion( 'MD' );
    $from->setPostalCode( 21093 );
    $from->setCountry( 'US' );

    $client->setFromAddress( $from );

    # populate to address
    $to = new Address();

    $to->setName( 'Imani Imaginarium' );
    $to->setLine1( '21 ARGONAUT SUITE B' );
    $to->setCity( 'ALISO VIEJO' );
    $to->setRegion( 'CA' );
    $to->setPostalCode( 92656 );
    $to->setCountry( 'US' );

    $client->setToAddress( $to );

    # add package(s) to request
    $package1 = new Package();
    $package1->setHeight( 10 );
    $package1->setWidth( 4 );
    $package1->setLength( 5 );
    $package1->setDimensionUnitOfMeasure( 'in' );
    $package1->setWeight( 1 );
    $package1->setWeightUnitOfMeasure( 'lbs' );

    $client->addPackage( $package1 );

    # submit request
    $response = $client->getRates();


Response
~~~~~~~~

.. code-block:: php

    MultiShip\Response\Collections\Rate Object
    (
        [rates:protected] => Array
            (
                [0] => MultiShip\Response\Elements\Rate Object
                    (
                        [packageType:protected] => YOUR_PACKAGING
                        [billingPackage:protected] => MultiShip\Package\Package Object
                            (
                                [length:protected] =>
                                [width:protected] =>
                                [height:protected] =>
                                [dimensionUnitOfMeasure:protected] =>
                                [weight:protected] => 3.0
                                [weightUnitOfMeasure:protected] => LBS
                            )

                        [charges:protected] => Array
                            (
                                [0] => MultiShip\Charge\TransportationCharge Object
                                    (
                                        [type:protected] => Transportation
                                        [currencyCode:protected] => USD
                                        [value:protected] => 16.64
                                        [negative:protected] =>
                                    )

                                [1] => MultiShip\Charge\ServiceCharge Object
                                    (
                                        [type:protected] => Service
                                        [currencyCode:protected] => USD
                                        [value:protected] => 0.00
                                        [negative:protected] =>
                                    )

                                [2] => MultiShip\Charge\TotalCharge Object
                                    (
                                        [type:protected] => Total
                                        [currencyCode:protected] => USD
                                        [value:protected] => 16.64
                                        [negative:protected] =>
                                    )

                            )

                        [deliveryGuarantee:protected] =>
                        [ratedPackages:protected] => Array
                            (
                                [0] => MultiShip\Package\RatedPackage Object
                                    (
                                        [charges:protected] => Array
                                            (
                                                [0] => MultiShip\Charge\TransportationCharge Object
                                                    (
                                                        [type:protected] => Transportation
                                                        [currencyCode:protected] => USD
                                                        [value:protected] => 7.75
                                                        [negative:protected] =>
                                                    )

                                                [1] => MultiShip\Charge\ServiceCharge Object
                                                    (
                                                        [type:protected] => Service
                                                        [currencyCode:protected] => USD
                                                        [value:protected] => 0.00
                                                        [negative:protected] =>
                                                    )

                                                [2] => MultiShip\Charge\TotalCharge Object
                                                    (
                                                        [type:protected] => Total
                                                        [currencyCode:protected] => USD
                                                        [value:protected] => 7.75
                                                        [negative:protected] =>
                                                    )

                                            )

                                        [billingPackage:protected] => MultiShip\Package\Package Object
                                            (
                                                [length:protected] =>
                                                [width:protected] =>
                                                [height:protected] =>
                                                [dimensionUnitOfMeasure:protected] =>
                                                [weight:protected] => 1.0
                                                [weightUnitOfMeasure:protected] => LBS
                                            )

                                        [length:protected] =>
                                        [width:protected] =>
                                        [height:protected] =>
                                        [dimensionUnitOfMeasure:protected] =>
                                        [weight:protected] => 1.0
                                        [weightUnitOfMeasure:protected] =>
                                    )

                                [1] => MultiShip\Package\RatedPackage Object
                                    (
                                        [charges:protected] => Array
                                            (
                                                [0] => MultiShip\Charge\TransportationCharge Object
                                                    (
                                                        [type:protected] => Transportation
                                                        [currencyCode:protected] => USD
                                                        [value:protected] => 8.89
                                                        [negative:protected] =>
                                                    )

                                                [1] => MultiShip\Charge\ServiceCharge Object
                                                    (
                                                        [type:protected] => Service
                                                        [currencyCode:protected] => USD
                                                        [value:protected] => 0.00
                                                        [negative:protected] =>
                                                    )

                                                [2] => MultiShip\Charge\TotalCharge Object
                                                    (
                                                        [type:protected] => Total
                                                        [currencyCode:protected] => USD
                                                        [value:protected] => 8.89
                                                        [negative:protected] =>
                                                    )

                                            )

                                        [billingPackage:protected] => MultiShip\Package\Package Object
                                            (
                                                [length:protected] =>
                                                [width:protected] =>
                                                [height:protected] =>
                                                [dimensionUnitOfMeasure:protected] =>
                                                [weight:protected] => 2.0
                                                [weightUnitOfMeasure:protected] => LBS
                                            )

                                        [length:protected] =>
                                        [width:protected] =>
                                        [height:protected] =>
                                        [dimensionUnitOfMeasure:protected] =>
                                        [weight:protected] => 2.0
                                        [weightUnitOfMeasure:protected] =>
                                    )

                            )

                        [notes:protected] => Array
                            (
                                [0] => MultiShip\Response\Elements\Note Object
                                    (
                                        [id:protected] =>
                                        [code:protected] => 110971
                                        [description:protected] => Your invoice may vary from the displayed reference rates
                                    )

                                [1] => MultiShip\Response\Elements\Note Object
                                    (
                                        [id:protected] =>
                                        [code:protected] => 110920
                                        [description:protected] => Ship To Address Classification is changed from Residential to Commercial
                                    )

                            )

                        [carrierCode:protected] => Ups
                        [serviceCode:protected] => 03
                        [serviceDescription:protected] =>
                        [total:protected] => MultiShip\Charge\TotalCharge Object
                            (
                                [type:protected] => Total
                                [currencyCode:protected] => USD
                                [value:protected] => 16.64
                                [negative:protected] =>
                            )

                    )
            )

        [notes:protected] =>
        [statusCode:protected] =>
        [statusDescription:protected] =>
        [count:protected] => 1
    )


getSimpleRates
--------------

Request
~~~~~~~

.. code-block:: php

    # populate from address
    $from = new Address();

    $from->setName( 'Imani Carr' );
    $from->setNumber( 222006 );
    $from->setLine1( 'Southam Rd' );
    $from->setLine2( '4 Case Cour' );
    $from->setLine3( 'Apt 3B' );
    $from->setCity( 'Timonium' );
    $from->setRegion( 'MD' );
    $from->setPostalCode( 21093 );
    $from->setCountry( 'US' );

    $client->setFromAddress( $from );

    # populate to address
    $to = new Address();

    $to->setName( 'Imani Imaginarium' );
    $to->setLine1( '21 ARGONAUT SUITE B' );
    $to->setCity( 'ALISO VIEJO' );
    $to->setRegion( 'CA' );
    $to->setPostalCode( 92656 );
    $to->setCountry( 'US' );

    $client->setToAddress( $to );

    # add package(s) to request
    $package1 = new Package();
    $package1->setHeight( 10 );
    $package1->setWidth( 4 );
    $package1->setLength( 5 );
    $package1->setDimensionUnitOfMeasure( 'in' );
    $package1->setWeight( 1 );
    $package1->setWeightUnitOfMeasure( 'lbs' );

    $client->addPackage( $package1 );

    # submit request
    $response = $client->getSimpleRates();

Response
~~~~~~~~

.. code-block:: php

    MultiShip\Response\Collections\Rate Object
    (
        [rates:protected] => Array
            (
                [0] => MultiShip\Response\Elements\SimpleRate Object
                    (
                        [carrierCode:protected] => Ups
                        [serviceCode:protected] => 03
                        [serviceDescription:protected] =>
                        [total:protected] => MultiShip\Charge\TotalCharge Object
                            (
                                [type:protected] => Total
                                [currencyCode:protected] => USD
                                [value:protected] => 16.64
                                [negative:protected] =>
                            )

                    )

                [1] => MultiShip\Response\Elements\SimpleRate Object
                    (
                        [carrierCode:protected] => Ups
                        [serviceCode:protected] => 12
                        [serviceDescription:protected] =>
                        [total:protected] => MultiShip\Charge\TotalCharge Object
                            (
                                [type:protected] => Total
                                [currencyCode:protected] => USD
                                [value:protected] => 40.34
                                [negative:protected] =>
                            )

                    )

            )

        [notes:protected] =>
        [statusCode:protected] =>
        [statusDescription:protected] =>
        [count:protected] => 2
    )
