<?php
// api/includes/auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    if (function_exists('baseUrl')) {
        header("Location: " . baseUrl() . "auth/login.php");
    } else {
        header("Location: /auth/login.php");
    }
    exit;
}
?>