<?php
// api/auth/logout.php

require_once __DIR__ . '/../includes/init.php';

// 1. Hapus semua data session
$_SESSION = array();

// 2. Hancurkan session
session_destroy();

// 3. PERBAIKAN: Hapus '../' dari appUrl()
// appUrl() sudah otomatis menambahkan folder 'api/' saat di lokal
header("Location: " . appUrl('auth/login.php'));
exit;
?>