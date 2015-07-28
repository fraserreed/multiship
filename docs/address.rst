.. index::
   single: Addresses

.. _addresses:

Addresses
=========

Both to and from addresses are required for most types of requests.  Each address is built using
the same ``Address`` object, although some properties will be ignored on the ``from`` address.

After an address is constructed, it must be applied to the **MultiShip** ``$client`` before executing the
desired request.

For information on how to set up the ``$client`` object, see :ref:`Getting Started <gettingStarted>`.

Properties
~~~~~~~~~~

The address object contains the following properties:

==================   ============ ============
Property             Datatype
==================   ============ ============
name                 string       **required**
number               int
line1                string
line2                string
line3                string
city                 string
region               string
postalCode           string
country              string
residential          boolean
==================   ============ ============

Example
~~~~~~~

To add the ``from`` address for the request, construct the address and call the ``setFromAddress()`` function.

.. code-block:: php
    # populate from address
    $from = new \MultiShip\Address\Address();

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


To add the ``to`` address for the request, construct the address and call the ``setToAddress()`` function.

.. code-block:: php
    # populate to address
    $to = new \MultiShip\Address\Address();

    $to->setName( 'Imani Imaginarium' );
    $to->setLine1( '21 ARGONAUT SUITE B' );
    $to->setCity( 'ALISO VIEJO' );
    $to->setRegion( 'CA' );
    $to->setPostalCode( 92656 );
    $to->setCountry( 'US' );
    $to->setResidentialAddress( true );

    $client->setToAddress( $to );
