<?php
// api/auth/proses_login.php

require_once __DIR__ . '/../includes/init.php';
// Baris require_once csrf.php SUDAH DIHAPUS

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . appUrl('auth/login.php'));
    exit;
}

// Verifikasi CSRF Token (Fungsi ini sekarang ada di init.php)
csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan Password wajib diisi!";
    $_SESSION['error_type'] = "warning";
    header("Location: " . appUrl('auth/login.php'));
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Mencegah Session Fixation
    session_regenerate_id(true); 

    $_SESSION['user_id']      = $user['id'];
    $_SESSION['username']     = $user['username'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    $_SESSION['role']         = $user['role'];

    header("Location: " . appUrl('index.php'));
    exit;
} else {
    $_SESSION['error'] = "Username atau Password yang Anda masukkan salah!";
    $_SESSION['error_type'] = "error";
    header("Location: " . appUrl('auth/login.php'));
    exit;
}
?>