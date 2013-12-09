.. index::
   single: Testing

Testing
=======

Unit Testing
------------

MultiShip uses PHPUnit for unit testing.

In order to run the unit tests, you'll first need
to install the dependencies of the project using Composer:

.. code-block:: php

    php composer.phar install --dev

You can then run the tests using

.. code-block:: php

    vendor/bin/phpunit --configuration tests/phpunit.xml

Code coverage reports are generated into the ``report`` folder in html and clover xml format.