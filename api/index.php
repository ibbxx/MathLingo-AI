<?php

/**
 * Vercel Serverless Bootstrap for Laravel (MathLingo-AI)
 *
 * This file acts as the entry point for Vercel's PHP serverless functions.
 */

// ── 1. Set Native Laravel Storage Path for Serverless ────────────────────
// Laravel 11/12 natively uses LARAVEL_STORAGE_PATH environment variable.
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
putenv('LARAVEL_STORAGE_PATH=/tmp/storage');

// Laravel may need to compile provider/package manifests on cold starts.
// Vercel's deployment filesystem is read-only, so keep those caches in /tmp.
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');

$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');

// ── 2. Write SSL CA certificate from environment variable to /tmp ────────
$sslCaContent = $_ENV['MYSQL_SSL_CA_CONTENT'] ?? getenv('MYSQL_SSL_CA_CONTENT') ?: null;

if ($sslCaContent && !file_exists('/tmp/ca.pem')) {
    file_put_contents('/tmp/ca.pem', $sslCaContent);
}

if (file_exists('/tmp/ca.pem')) {
    $_ENV['MYSQL_ATTR_SSL_CA'] = '/tmp/ca.pem';
    $_SERVER['MYSQL_ATTR_SSL_CA'] = '/tmp/ca.pem';
    putenv('MYSQL_ATTR_SSL_CA=/tmp/ca.pem');
}

// ── 3. Ensure correct working directory ──────────────────────────────────
chdir(__DIR__ . '/..');

// ── 4. Ensure writable directories exist in /tmp/storage ─────────────────
$tmpDirs = [
    '/tmp/bootstrap/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// ── 5. Route compiled Blade views to writable /tmp storage ───────────────
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// ── 6. Bootstrap Laravel ─────────────────────────────────────────────────
require __DIR__ . '/../public/index.php';
