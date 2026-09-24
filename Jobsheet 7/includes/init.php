<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============ SEED DATA AWAL ============
if (!isset($_SESSION['seni'])) {
    $_SESSION['seni'] = [
        ['id' => 1710000000001, 'no_divisi' => '1', 'nama_divisi' => 'Teater Utama',     'keterangan' => 'Divisi utama yang berfokus pada pementasan drama dan teater modern.', 'tahun' => '2020'],
        ['id' => 1710000000002, 'no_divisi' => '2', 'nama_divisi' => 'Tari Tradisional', 'keterangan' => 'Divisi yang menampilkan tarian daerah dan pertunjukan budaya.',      'tahun' => '2021'],
        ['id' => 1710000000003, 'no_divisi' => '3', 'nama_divisi' => 'Musik Akustik',    'keterangan' => 'Divisi pengiring musik untuk setiap pementasan seni.',              'tahun' => '2022'],
    ];
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [
        ['id' => 1710000000004, 'nama' => 'Budi Santoso',  'no_anggota' => 'A-001', 'alamat' => 'Jakarta Selatan', 'no_hp' => '081234567890'],
        ['id' => 1710000000005, 'nama' => 'Siti Aminah',   'no_anggota' => 'A-002', 'alamat' => 'Bandung',         'no_hp' => '089876543210'],
        ['id' => 1710000000006, 'nama' => 'Andi Pratama',  'no_anggota' => 'A-003', 'alamat' => 'Surabaya',        'no_hp' => '085555555555'],
    ];
}

// ============ BASE URL OTOMATIS ============
function baseUrl() {
    $script = $_SERVER['SCRIPT_NAME'];
    $root   = rtrim(dirname($script), '/\\');
    $base   = basename($root);
    if (in_array($base, ['Seni', 'Anggota', 'includes'])) {
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

function cariIndexById($array, $id) {
    foreach ($array as $i => $item) {
        if ($item['id'] == $id) return $i;
    }
    return -1;
}