<?php
// api/config/koneksi.php

$host = 'localhost';
$port = '5432'; // Port PostgreSQL
$db   = 'seni_theatrisic';
$user = 'postgres'; 
$pass = 'Igmaida133'; // GANTI DENGAN PASSWORD POSTGRESQL ANDA

$dsn = "pgsql:host=$host;port=$port;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>