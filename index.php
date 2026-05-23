<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/*
 * Laragon/Windows: suppress display_errors so PHP warnings (e.g. proc_open/git)
 * do not prepend HTML to JSON API responses.
 */
ini_set('display_errors', '0');

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = 'storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require 'vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once 'bootstrap/app.php';

$app->handleRequest(Request::capture());
