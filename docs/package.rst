.. index::
   single: Packages

.. _packages:

Packages
========

Both rate requests and shipment requests require packages, or the rate and shipment requests will
not be able to be completed.  Each request can have one or more packages, but all packages must
be sent from the same to address to the same from address.

For information on how to set the ``to`` and ``from`` addresses, see :ref:`Addresses <addresses>`.

Packages are built using the :ref:``Package <requestPackage>`` object.

Rate and shipment responses will also contain packages, representing the shippable assets for the rate
or shipment.

Available response packages are defined in the :ref:`Package Response <responsePackage>` section.

.. _requestPackage:

Request Package
---------------

A package represents a single shippable item to be processed by a shipping carrier.  The package object is prepared
and populated as part of a **MultiShip** request.

The package object contains the following properties:

=======================   ============ ====================================
Property                  Datatype
=======================   ============ ====================================
height                    int          **required**
width                     int          **required**
length                    int          **required**
dimensionUnitOfMeasure    string       **required**, must be 'in' or 'cm'
weight                    int          **required**
weightUnitOfMeasure       string       **required**, must be 'kg' or 'lb'
=======================   ============ ====================================

For information on how to set up the ``$client`` object, see :ref:`Getting Started <gettingStarted>`.

To add a single package, simply construct the package and call the ``addPackage()`` function.

.. code-block:: php

    # add package(s) to request
    $package = new Package();
    $package->setHeight( 10 );
    $package->setWidth( 4 );
    $package->setLength( 5 );
    $package->setDimensionUnitOfMeasure( 'in' );
    $package->setWeight( 1 );
    $package->setWeightUnitOfMeasure( 'lbs' );

    $client->addPackage( $package );


To add a multiple packages, construct each of the individual package objects and call
the ``addPackage()`` function once per package constructed.

.. code-block:: php

    # add package(s) to request
    $package1 = new Package();
    $package1->setHeight( 10 );
    $package1->setWidth( 4 );
    $package1->setLength( 5 );
    $package1->setDimensionUnitOfMeasure( 'in' );
    $package1->setWeight( 1 );
    $package1->setWeightUnitOfMeasure( 'lbs' );

    $client->addPackage( $package1 );

    $package2 = new Package();
    $package2->setHeight( 24 );
    $package2->setWidth( 6 );
    $package2->setLength( 12 );
    $package2->setDimensionUnitOfMeasure( 'in' );
    $package2->setWeight( 4 );
    $package2->setWeightUnitOfMeasure( 'lbs' );

    $client->addPackage( $package2 );

.. _responsePackages:

Response Packages
-----------------

Packages may be returned as part of rate or shipment responses.  Definitions of those package types are below.

.. _responsePackage:

Package
~~~~~~~

A **Package** is an object containing the package size used to provide basic package dimensions and weight.

The package object contains the following properties:

=======================   ============
Property                  Datatype
=======================   ============
height                    int
width                     int
length                    int
dimensionUnitOfMeasure    string
weight                    int
weightUnitOfMeasure       string
=======================   ============

Below is an example **Package** object.

.. code-block:: php

    MultiShip\Package\Package Object
    (
        [length:protected] => 12.0
        [width:protected] => 12.0
        [height:protected] => 4.0
        [dimensionUnitOfMeasure:protected] => IN
        [weight:protected] => 2.0
        [weightUnitOfMeasure:protected] => LBS
    )

.. _ratedPackage:

Rated Package
~~~~~~~~~~~~~

A **Rated Package** is an object containing the package size used to provide a rate from a carrier.  The rated package
may not match the size of the actual package exactly.

The rated package object contains the following properties:

======================= ================================== ========================================
Property                Datatype                           Notes
======================= ================================== ========================================
charges                 array                              Contains :ref:`Charge <charges>` objects
billingPackage          :ref:`Package <responsePackage>`
height                  int
width                   int
length                  int
dimensionUnitOfMeasure  string
weight                  int
weightUnitOfMeasure     string
======================= ================================== ========================================


Below is an example **Rated Package** object.

.. code-block:: php

    MultiShip\Package\RatedPackage Object
    (
        [charges:protected] => Array
            (
                [0] => MultiShip\Charge\TransportationCharge Object
                    (
                        [type:protected] => Transportation
                        [currencyCode:protected] => USD
                        [value:protected] => 65.42
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
                        [value:protected] => 65.42
                        [negative:protected] =>
                    )

            )

        [billingPackage:protected] => MultiShip\Package\Package Object
            (
                [length:protected] => 12.0
                [width:protected] => 12.0
                [height:protected] => 4.0
                [dimensionUnitOfMeasure:protected] => IN
                [weight:protected] => 2.0
                [weightUnitOfMeasure:protected] => LBS
            )

        [length:protected] => 12.0
        [width:protected] => 12.0
        [height:protected] => 4.0
        [dimensionUnitOfMeasure:protected] => IN
        [weight:protected] => 2.0
        [weightUnitOfMeasure:protected] => LBS
