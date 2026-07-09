<?php

/**
 * Vercel Serverless Bootstrap for Laravel (MathLingo-AI)
 *
 * This file acts as the entry point for Vercel's PHP serverless functions.
 * It handles:
 * 1. Writing the Aiven SSL CA certificate from env var to /tmp
 * 2. Setting up the correct working directory
 * 3. Bootstrapping Laravel
 */

// ── 1. Write SSL CA certificate from environment variable to /tmp ────────
$sslCaContent = $_ENV['MYSQL_SSL_CA_CONTENT'] ?? getenv('MYSQL_SSL_CA_CONTENT') ?: null;

if ($sslCaContent && !file_exists('/tmp/ca.pem')) {
    file_put_contents('/tmp/ca.pem', $sslCaContent);
}

// Set the SSL CA path for Laravel's database config
if (file_exists('/tmp/ca.pem')) {
    $_ENV['MYSQL_ATTR_SSL_CA'] = '/tmp/ca.pem';
    $_SERVER['MYSQL_ATTR_SSL_CA'] = '/tmp/ca.pem';
    putenv('MYSQL_ATTR_SSL_CA=/tmp/ca.pem');
}

// ── 2. Ensure correct working directory ──────────────────────────────────
// Vercel runs from the api/ directory, but Laravel expects the project root
chdir(__DIR__ . '/..');

// ── 3. Ensure writable directories exist in /tmp ─────────────────────────
// Vercel's filesystem is read-only except for /tmp
$tmpDirs = [
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

// ── 4. Bootstrap Laravel ─────────────────────────────────────────────────
require __DIR__ . '/../public/index.php';
