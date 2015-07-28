# MultiShip

[![Build Status](https://secure.travis-ci.org/fraserreed/multiship.png?branch=master)](http://travis-ci.org/fraserreed/multiship)
[![Coverage Status](https://coveralls.io/repos/fraserreed/multiship/badge.png?branch=master)](https://coveralls.io/r/fraserreed/multiship?branch=master)

MultiShip is a multi-carrier shipping library for PHP 5.3+.

- Supports rate requests, shipment creation and label generation through UPS and FedEx APIs

Read the full documentation at [http://docs.multiship.org](http://docs.multiship.org).


## Installation

The recommended way to install MultiShip is through Composer.

Composer is a tool for dependency management in PHP. Please visit the
[Composer](http://getcomposer.org) website for more information.

```shell
curl -sS https://getcomposer.org/installer | php
```    

To install MultiShip simply add it as a dependency to your project's
``composer.json`` file:

```
{
    "require": {
        "fraserreed/multiship": "~1.0"
    }
}
```

Then run Composer to update your packages:

```shell
php composer.phar update
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Getting Started


### Request Basics

All requests require configuration for connecting to your preferred carrier or carriers.  Some requests
(getRates, getSimpleRates) support multiple carriers in one request, others (processShipment) only support
one carrier per request.

#### Carrier Configuration Parameters

Each parameter listed below is required for making MultiShip requests to the specified carrier.

UPS       | FedEx
--------- | -------------
accessKey | accessKey  
userId    | accountNumber 
password  | meterNumber 
          | password 

Optional Params
* debug (true / false)
* will determine if requests are made to sandbox/test carrier endpoint url or production carrier endpoint url

#### Example

Below is an example of a single carrier request:

```php
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
```

Below is an example of a multi-carrier request:

```php
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
```

For more details on constructing and sending requests, refer to [http://docs.multiship.org](http://docs.multiship.org).