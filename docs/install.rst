.. index::
   single: Installation

Installation
============

The recommended way to install MultiShip is through Composer.

Composer is a tool for dependency management in PHP. Please visit the
`Composer <http://getcomposer.org/>`_ website for more information.


To install Composer:

.. code-block:: bash

    curl -sS https://getcomposer.org/installer | php

To install MultiShip simply add it as a dependency to your project's
``composer.json`` file:

.. code-block:: javascript

    {
        "require": {
            "fraserreed/multiship": "*"
        }
    }

Then run Composer to update your packages:

.. code-block:: bash

    php composer.phar update

After installing, you need to require Composer's autoloader:

.. code-block:: php

    require 'vendor/autoload.php';
