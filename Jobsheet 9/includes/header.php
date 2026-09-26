<?php
require_once __DIR__ . '/init.php';
$baseUrl    = baseUrl();
$activePage = $activePage ?? '';
$page_title = $page_title ?? 'Seni Theatrisic';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title) ?> | Seni Theatrisic</title>
  <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">
</head>
<body>
  <header>
    <h1><span>🎭</span> Seni Theatrisic</h1>
    <input type="checkbox" id="menu-toggle" class="menu-checkbox" style="display:none;"/>
    <label for="menu-toggle" class="hamburger-icon">&#9776;</label>
    <nav>
      <ul>
        <li><a href="<?= $baseUrl ?>index.php"          class="<?= $activePage==='beranda'       ? 'active' : '' ?>">Beranda</a></li>
        <li><a href="<?= $baseUrl ?>Seni/list.php"      class="<?= $activePage==='seni-list'     ? 'active' : '' ?>">Daftar Seni</a></li>
        <li><a href="<?= $baseUrl ?>Seni/tambah.php"    class="<?= $activePage==='seni-tambah'   ? 'active' : '' ?>">Tambah Seni</a></li>
        <li><a href="<?= $baseUrl ?>Anggota/list.php"   class="<?= $activePage==='anggota-list'  ? 'active' : '' ?>">Daftar Anggota</a></li>
        <li><a href="<?= $baseUrl ?>Anggota/tambah.php" class="<?= $activePage==='anggota-tambah'? 'active' : '' ?>">Tambah Anggota</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <?php $flash = getFlash(); if ($flash): ?>
      <div class="flash flash-<?= e($flash['type']) ?>" id="flash-alert">
        <span class="flash-icon"><?= $flash['type'] === 'success' ? '✅' : '⚠️' ?></span>
        <span class="flash-text"><?= e($flash['pesan']) ?></span>
        <button type="button" class="flash-close" onclick="this.parentElement.remove()">✕</button>
      </div>
    <?php endif; ?>