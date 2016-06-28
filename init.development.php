<?php declare(strict_types=1);

namespace Gitilicious;

/**
 * Setup error reporting
 */
ini_set('display_startup_errors', 'On');
ini_set('display_errors', 'On');
error_reporting(-1);

/**
 * Set up the environment type
 *
 * This is a.o. used to determine whether we need to used cached versions of the routes and the public resources
 */
$production = false;
