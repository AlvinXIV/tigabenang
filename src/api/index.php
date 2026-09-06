<?php

// Pastikan direktori sementara /tmp untuk runtime Laravel di Vercel Serverless tersedia
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Teruskan seluruh request HTTP ke public/index.php milik Laravel
require __DIR__ . '/../public/index.php';
