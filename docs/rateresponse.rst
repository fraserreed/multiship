.. index::
   single: Rate Responses

Rate Responses
==============

The response returned from a rate request will be comprised of a single :ref:`Rate Collection <rateCollection>` object
with zero or more rate elements.  Depending on what type of request was made, the rates will either be described by
:ref:`Rate Element <rateElement>` objects (for :ref:`getRates()<getRates>` requests), or by
:ref:`Simple Rate Element <simpleRateElement>` objects (for :ref:`getSimpleRates() <getSimpleRates>` requests).


.. _rateCollection:

Rate Collection
---------------

A **Rate Collection** is an object that contains an array of individual rate elements, along with some summary
information for the response.

The rate collection object contains the following properties:

==================   ============ =====================================================
Property             Datatype     Notes
==================   ============ =====================================================
rates                array        Contains the detailed or simplified rate elements
notes                array        Contains any notes returned by the shipping carrier
statusCode           string       Success / failure code of request
statusDescription    string       Success / failure explanation of request
count                int          Number of rate elements returned
==================   ============ =====================================================

All properties can be accessed using standard ``getter`` methods (``getRates()``, ``getCount()`` etc.).

Below is an example **Rate Collection** object.

.. code-block:: php

    MultiShip\Response\Collections\Rate Object
    (
        [rates:protected] => Array
            (
                ...
            )
        [notes:protected] => Array
            (
                ...
            )
        [statusCode:protected] => SUCCESS
        [statusDescription:protected] => The request was successful
        [count:protected] => 8
    )

.. _rateElement:

Rate Element
------------

A **Rate Element** is an object that contains detailed information on a single rate returned from the carrier.
This type of rate element is returned as part of the :ref:`Rate Collection <rateCollection>` for
:ref:`getRates() <getRates>` requests.  For a simpler version of the same rate, use :ref:`getSimpleRates() <getSimpleRates>`,
which will return :ref:`simpleRateElement <simpleRateElement>` objects.

The rate element object contains the following properties:

==================   ============================================ =====================================================
Property             Datatype                                     Notes
==================   ============================================ =====================================================
packageType          string
billingPackage       :ref:`Package <packages>`
charges              array                                        Contains :ref:`Charge <charges>` objects
deliveryGuarantee    :ref:`DeliveryGuarantee <deliveryGuarantee>`
ratedPackages        array                                        Contains :ref:`RatedPackage <ratedPackage>` objects
notes                array                                        Contains :ref:`Note <note>` objects
carrierCode          string                                       Carrier code for rate provider
serviceCode          string                                       Carrier specific code for rated service
serviceDescription   string                                       Carrier specific description for rated service
total                :ref:`TotalCharge <totalCharge>`             Object containing details of total charge for rate
==================   ============================================ =====================================================

Below is an example **Rate Element** object.

.. code-block:: php

    MultiShip\Response\Elements\Rate Object
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
        [serviceDescription:protected] => Ups Ground
        [total:protected] => MultiShip\Charge\TotalCharge Object
            (
                [type:protected] => Total
                [currencyCode:protected] => USD
                [value:protected] => 16.64
                [negative:protected] =>
            )

    )

.. _simpleRateElement:

Simple Rate Element
-------------------

A **Simple Rate Element** is an object that contains basic information on a single rate returned from the carrier.
This type of rate element is returned as part of the :ref:`Rate Collection <rateCollection>` for
:ref:`getSimpleRates() <getSimpleRates>` requests.

The simple rate element object contains the following properties:

==================   ============================================ =====================================================
Property             Datatype                                     Notes
==================   ============================================ =====================================================
carrierCode          string                                       Carrier code for rate provider
serviceCode          string                                       Carrier specific code for rated service
serviceDescription   string                                       Carrier specific description for rated service
total                :ref:`TotalCharge <totalCharge>`             Object containing details of total charge for rate
==================   ============================================ =====================================================

Below is an example **Rate Element** object.


.. code-block:: php

    MultiShip\Response\Elements\SimpleRate Object
    (
        [carrierCode:protected] => Ups
        [serviceCode:protected] => 03
        [serviceDescription:protected] => Ups Ground
        [total:protected] => MultiShip\Charge\TotalCharge Object
            (
                [type:protected] => Total
                [currencyCode:protected] => USD
                [value:protected] => 16.64
                [negative:protected] =>
            )

    )
