<?php

/*
 * This file is part of the MultiShip package.
 *
 * (c) 2013 Fraser Reed
 *      <fraser.reed@gmail.com>
 *      github.com/fraserreed
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

error_reporting( E_ALL | E_STRICT );

// Ensure that composer has installed all dependencies
if( !file_exists( dirname( __DIR__ ) . '/composer.lock' ) )
{
    die( "Dependencies must be installed using composer:\n\nphp composer.phar install --dev\n\n"
        . "See http://getcomposer.org for help with installing composer\n" );
}

require_once 'PHPUnit/TextUI/TestRunner.php';

// Include the composer autoloader
$autoloader = require dirname( __DIR__ ) . '/vendor/autoload.php';