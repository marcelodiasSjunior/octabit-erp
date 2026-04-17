<?php

$laravelRoot = dirname(__DIR__) . '/laravel_app';
$laravelPublic = $laravelRoot . '/public';

if (! is_dir($laravelRoot) || ! is_file($laravelPublic . '/index.php')) {
    http_response_code(503);
    echo '<h1>Application unavailable</h1>';
    exit;
}

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$decodedPath = rawurldecode($requestPath);
$candidateFile = realpath($laravelPublic . DIRECTORY_SEPARATOR . ltrim($decodedPath, '/'));
$publicRoot = realpath($laravelPublic);

$mimeTypes = [
    'css' => 'text/css; charset=UTF-8',
    'js' => 'application/javascript; charset=UTF-8',
    'json' => 'application/json; charset=UTF-8',
    'svg' => 'image/svg+xml',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'webp' => 'image/webp',
    'ico' => 'image/x-icon',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf' => 'font/ttf',
    'eot' => 'application/vnd.ms-fontobject',
    'txt' => 'text/plain; charset=UTF-8',
];

if ($candidateFile !== false && $publicRoot !== false && is_file($candidateFile)) {
    if (str_starts_with($candidateFile, $publicRoot . DIRECTORY_SEPARATOR)) {
        $extension = strtolower(pathinfo($candidateFile, PATHINFO_EXTENSION));
        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

        if (function_exists('header_remove')) {
            header_remove('Content-Type');
        }

        header('Content-Type: ' . $mimeType, true);
        header('Content-Length: ' . (string) filesize($candidateFile), true);
        readfile($candidateFile);
        exit;
    }
}

require_once $laravelPublic . '/index.php';
