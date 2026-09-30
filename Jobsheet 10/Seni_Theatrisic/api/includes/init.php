<?php
// api/includes/init.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Panggil koneksi database
require_once __DIR__ . '/../config/koneksi.php';

// ============ DETEKSI VERCEL (DIPERKETAT) ============
function isVercel() {
    return isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']);
}

// ============ BASE URL (Untuk Aset CSS/JS/Gambar) ============
function baseUrl() {
    if (isVercel()) {
        return '/'; 
    }
    
    $script = $_SERVER['SCRIPT_NAME']; // Contoh: /Seni_Theatrisic/api/auth/logout.php
    $root   = rtrim(dirname($script), '/\\'); // Hasil: /Seni_Theatrisic/api/auth
    $root   = str_replace('\\', '/', $root);
    
    // Loop naik ke folder utama
    $base = basename($root);
    while (in_array($base, ['Seni', 'Anggota', 'includes', 'config', 'auth', 'api'])) {
        $root = dirname($root);
        $base = basename($root);
    }
    return rtrim($root, '/\\') . '/'; // Hasil akhir: /Seni_Theatrisic/
}

// ============ APP URL (Untuk Link Halaman PHP) ============
function appUrl($path = '') {
    $prefix = isVercel() ? '' : 'api/'; 
    return baseUrl() . $prefix . ltrim($path, '/');
}

// ============ HELPERS ============
function e($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function setFlash($type, $pesan) {
    $_SESSION['flash'] = ['type' => $type, 'pesan' => $pesan];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}
?>