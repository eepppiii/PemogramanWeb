<?php
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . appUrl('auth/login.php'));
    exit;
}
?>