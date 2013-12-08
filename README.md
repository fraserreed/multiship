# MultiShip

[![Build Status](https://secure.travis-ci.org/fraserreed/multiship.png?branch=master)](http://travis-ci.org/fraserreed/multiship)
[![Coverage Status](https://coveralls.io/repos/fraserreed/multiship/badge.png?branch=master)](https://coveralls.io/r/fraserreed/multiship?branch=master)

MultiShip is a multi-carrier shipping library for PHP 5.3+.

- Supports UPS and FedEx APIs
  - Rate requests
  - Weighbill label generation
  - Package tracking 
- Generic, aggregate responses to multiple shipping libraries using a simple interface.


### Installing via Composer

The recommended way to install MultiShip is through [Composer](http://getcomposer.org).

```
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add MultiShip as a dependency
php composer.phar require fraserreed/multiship:~dev-master
```

After installing, you need to require Composer's autoloader:

```
require 'vendor/autoload.php';
```

# Features
--------

- Supported requests
  - getRates
  - getSimpleRates  
- Responses provided in a generic format, regardless of carrier providing details

# Request basics
-----------

Initialize request with an array of carriers for the request.  One or more carriers are required.

### Required parameters per carrier
#### UPS
* accessKey
* userId
* password

#### FedEx
* accessKey
* accountNumber
* meterNumber
* password


```
<?php

use MultiShip\MultiShip;

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

$client = new MultiShip( $options );

```

# Supported Requests
-----------

## getRates
#### Request

```
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
```

#### Response

```
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

```

### getSimpleRates
#### Request

```
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
```

#### Response

```
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

```



Unit testing
------------

MultiShip uses PHPUnit for unit testing. 

In order to run the unit tests, you'll first need
to install the dependencies of the project using Composer: ``php composer.phar install --dev``.
You can then run the tests using ``vendor/bin/phpunit --configuration tests/phpunit.xml``.

Code coverage reports are generated into the ``report`` folder.