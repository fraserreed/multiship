.. index::
   single: Getting Started

Getting Started
===============

Request Basics
--------------

All requests require configuration for connecting to your preferred carrier or carriers.  Some requests
(getRates, getSimpleRates) support multiple carriers in one request, others (processShipment) only support
one carrier per request.

Carrier Configuration Parameters
--------------------------------

Each parameter listed below is required for making MultiShip requests to the specified carrier.

UPS
~~~~
* accessKey
* userId
* password

FedEx
~~~~~
* accessKey
* accountNumber
* meterNumber
* password

Optional Params
~~~~~~~~~~~~~~~
* debug (true / false)
* will determine if requests are made to sandbox/test carrier endpoint url or production carrier endpoint url

.. _gettingStarted:

Example
-------

Below is an example of a single carrier request:

.. code-block:: php

  <?php

  $options = array(
	'ups'   => array(
		'accessKey' => "BC987DE765FG543",
		'userId'    => "multiship",
		'password'  => "SuperSecret",
		'debug'     => true
	)
  );

  $client = new \MultiShip\MultiShip( $options );

  //execute request


Below is an example of a multi-carrier request:

.. code-block:: php

  <?php

  $options = array(
	'ups'   => array(
		'accessKey' => "BC987DE765FG543",
		'userId'    => "multiship",
		'password'  => "SuperSecret",
		'debug'     => true
	),
	'fedex' => array(
		'accessKey'     => "yabbaDabba600",
		'accountNumber' => "12340012",
		'meterNumber'   => "118000811",
		'password'      => "NotSoSuperSecret",
		'debug'         => true
	)
  );

  $client = new \MultiShip\MultiShip( $options );

  //execute request

