<?php

/**
 * OctaBit ERP — Entry point via /erp/ path
 * Bootstraps the Laravel application from the laravel_app directory.
 */

// Point to the Laravel app root (two levels up from public_html/erp/, then into laravel_app symlink)
$laravelBase = dirname(__DIR__, 2) . '/laravel_app';

// Validate Laravel installation exists
if (!file_exists($laravelBase . '/vendor/autoload.php')) {
    http_response_code(503);
    echo 'ERP application is being deployed. Please try again in a few minutes.';
    exit(1);
}

define('LARAVEL_START', microtime(true));

// Maintenance mode
if (file_exists($maintenance = $laravelBase . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Change to Laravel's public directory context for asset resolution
chdir($laravelBase . '/public');

// Register the Composer autoloader
require $laravelBase . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request
(require_once $laravelBase . '/bootstrap/app.php')
    ->handleRequest(Illuminate\Http\Request::capture());
