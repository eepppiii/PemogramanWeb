<?php
$host     = 'localhost';
$port     = '5432';
$dbname   = 'seni_theatrisic';
$username = 'postgres';
$password = 'Igmaida133';   

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('<div style="padding:2rem;background:#f8d7da;color:#721c24;font-family:sans-serif;">
            <h3>❌ Koneksi Database Gagal</h3>
            <p>' . htmlspecialchars($e->getMessage()) . '</p>
         </div>');
}