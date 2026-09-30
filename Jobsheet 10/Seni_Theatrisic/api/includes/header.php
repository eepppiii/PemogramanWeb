<?php
// api/includes/header.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sudahLogin = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - Seni Theatrisic' : 'Seni Theatrisic'; ?></title>
    <!-- baseUrl() khusus untuk CSS/JS -->
    <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/style.css?v=<?= time() ?>">
</head>

<body>

    <header class="main-header">
        <div class="header-container">
            <!-- appUrl() khusus untuk halaman PHP -->
            <a href="<?= appUrl('index.php') ?>" class="logo">
                <span class="logo-icon">🎭</span>
                <span class="logo-text">Seni Theatrisic</span>
            </a>

            <input type="checkbox" id="menu-toggle" class="menu-checkbox">

            <label for="menu-toggle" class="hamburger-btn">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <nav class="main-nav">
                <ul>
                    <li>
                        <a href="<?= appUrl('index.php') ?>"
                            class="<?= ($activePage == 'beranda') ? 'active' : '' ?>">Beranda</a>
                    </li>
                    <li>
                        <a href="<?= appUrl('Seni/list.php') ?>"
                            class="<?= ($activePage == 'seni') ? 'active' : '' ?>">Data Seni</a>
                    </li>
                    <li>
                        <a href="<?= appUrl('Anggota/list.php') ?>"
                            class="<?= ($activePage == 'anggota') ? 'active' : '' ?>">Data Anggota</a>
                    </li>
                </ul>
            </nav>

            <div class="user-area">
                <?php if ($sudahLogin): ?>
                    <div class="user-badge">
                        <span class="user-avatar">👤</span>
                        <span class="user-name">Halo,
                            <strong><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? $_SESSION['username']) ?></strong></span>
                    </div>
                    <a href="<?= appUrl('auth/logout.php') ?>" class="btn-logout"
                        onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                        <span>🚪</span> Logout
                    </a>
                <?php else: ?>
                    <a href="<?= appUrl('auth/login.php') ?>" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="main-content">