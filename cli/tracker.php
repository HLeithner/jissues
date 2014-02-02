#!/usr/bin/env php
<?php
/**
 * Part of the Joomla! Tracker application.
 *
 * @copyright  Copyright (C) 2012 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

use Application\Application;

'cli' == PHP_SAPI
	|| die("\nThis script must be run from the command line interface.\n\n");

version_compare(PHP_VERSION, '5.3.10') >= 0
	|| die("\nThis application requires PHP version >= 5.3.10 (Your version: " . PHP_VERSION . ")\n\n");

// Configure error reporting to maximum for CLI output.
error_reporting(-1);
ini_set('display_errors', 1);

// Load the autoloader
$loader = include __DIR__ . '/../vendor/autoload.php';

if (false == $loader)
{
	echo 'ERROR: Composer not properly set up! Run "composer install" or see README.md for more details' . PHP_EOL;

	exit(1);
}

// Add the namespace for our application to the autoloader.
/* @type Composer\Autoload\ClassLoader $loader */
$loader->add('Application', __DIR__);

define('JPATH_ROOT', realpath(__DIR__ . '/..'));

try
{
	with(new Application)->execute();
}
catch (\Exception $e)
{
	echo "\n\nERROR: " . $e->getMessage() . "\n\n";

	echo $e->getTraceAsString();

	exit($e->getCode() ? : 255);
}
