<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';

// ============ BASE URL OTOMATIS ============
function baseUrl() {
    $script = $_SERVER['SCRIPT_NAME'];
    $root   = rtrim(dirname($script), '/\\');
    $base   = basename($root);
    if (in_array($base, ['Seni', 'Anggota', 'includes', 'config'])) {
        $root = dirname($root);
    }
    return rtrim($root, '/\\') . '/';
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