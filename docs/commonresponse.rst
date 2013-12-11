.. index::
   single: Common Response Objects

Common Response Objects
=======================

There are a number of common response objects that are returned from rate or shipment requests.

.. _charges:
.. _totalCharge:

Charges
-------

A charge is an object containing monetary information on a type of fee or charge returned from the shipping carrier.

There are a number of charge types that may be returned, each containing a common set of properties.  The list of charge types
are:

* BaseCharge
* FreightCharge
* FreightDiscountCharge
* NetCharge
* ServiceCharge
* SurchargeCharge
* TaxCharge
* TotalCharge
* TransportationCharge

Each charge object contains the following common properties:

==================   ============ =====================================================
Property             Datatype     Notes
==================   ============ =====================================================
type                 string       Descriptive label of charge type
currencyCode         string
value                string       The monetary value of the charge
negative             boolean      A true negative value indicates this is a discount
==================   ============ =====================================================

All properties can be accessed using standard ``getter`` methods (``getCurrencyCode()``, ``getValue()`` etc.).

Below are a few examples of **Charge** object.

.. code-block:: php

    MultiShip\Charge\TransportationCharge Object
    (
        [type:protected] => Transportation
        [currencyCode:protected] => USD
        [value:protected] => 16.64
        [negative:protected] =>
    )

    MultiShip\Charge\FreightDiscountCharge Object
    (
        [type:protected] => FreightDiscount
        [currencyCode:protected] => USD
        [value:protected] => 4.50
        [negative:protected] => true
    )

    MultiShip\Charge\TotalCharge Object
    (
        [type:protected] => Total
        [currencyCode:protected] => USD
        [value:protected] => 16.64
        [negative:protected] =>
    )

.. _deliveryGuarantee:

Delivery Guarantee
------------------

A **Delivery Element** is an object that contains information provided by the shipping carrier about the expected
delivery time of a package, based on a rate or shipment.

The delivery guarantee object contains the following properties:

================== ============================================
Property           Datatype
================== ============================================
.
================== ============================================

.. _note:

Note
----

A **Note** is an object that contains additional information on a reference element.

The note object contains the following properties:

================== ============================================
Property           Datatype
================== ============================================
id                 int
code               string
description        string
================== ============================================


Below is an example **Rate Element** object.

.. code-block:: php

    MultiShip\Response\Elements\Note Object
    (
        [id:protected] =>
        [code:protected] => 110971
        [description:protected] => Your invoice may vary from the displayed reference rates
    )