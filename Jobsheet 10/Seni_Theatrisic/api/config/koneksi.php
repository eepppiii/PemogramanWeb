<?php
// api/config/koneksi.php

// Ambil dari Environment Variables (Vercel) atau fallback ke lokal
$host     = getenv('DB_HOST') ?: 'localhost';
$port     = getenv('DB_PORT') ?: '5432';
$dbname   = getenv('DB_NAME') ?: 'seni_theatrisic';
$username = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASS') ?: 'Igmaida133';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

} catch (PDOException $e) {
    die('<div style="padding:2rem;background:#f8d7da;color:#721c24;font-family:sans-serif;">
            <h3>Koneksi Database Gagal</h3>
            <p>' . htmlspecialchars($e->getMessage()) . '</p>
         </div>');
}
?>