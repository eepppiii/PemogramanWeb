<?php
require_once __DIR__ . '/includes/init.php';

$page_title = 'Dashboard';
$activePage = 'beranda';

$totalSeni    = $pdo->query("SELECT COUNT(*) FROM seni")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero-section">
  <div class="hero-content">
    <span class="hero-badge">✨ Portal Admin</span>
    <h1 class="hero-title">Selamat Datang di <br><span class="gradient-text">Seni Theatrisic</span></h1>
    <p class="hero-subtitle">Kelola divisi seni dan data keanggotaan organisasi dengan mudah, cepat, dan menyenangkan.</p>
    <div class="hero-actions">
      <a href="<?= baseUrl() ?>Seni/tambah.php" class="btn-primary"><span>➕</span> Tambah Divisi Seni</a>
      <a href="<?= baseUrl() ?>Anggota/tambah.php" class="btn-secondary"><span>👥</span> Daftarkan Anggota</a>
    </div>
  </div>
  <div class="hero-decoration">
    <div class="blob blob-1"></div><div class="blob blob-2"></div><div class="blob blob-3"></div>
  </div>
</section>

<div class="section-header">
  <h2>📊 Ringkasan Data</h2>
  <p>Pantau aktivitas organisasi Anda secara real-time</p>
</div>

<section class="stats-section">
  <article class="stat-card">
    <div class="stat-icon stat-icon-purple">🎭</div>
    <div class="stat-info">
      <h3>Total Divisi Seni</h3>
      <p><?= $totalSeni ?></p>
      <span class="stat-label">Divisi Aktif</span>
    </div>
  </article>
  <article class="stat-card">
    <div class="stat-icon stat-icon-blue">👥</div>
    <div class="stat-info">
      <h3>Total Anggota</h3>
      <p><?= $totalAnggota ?></p>
      <span class="stat-label">Anggota Terdaftar</span>
    </div>
  </article>
  <article class="stat-card">
    <div class="stat-icon stat-icon-green">📈</div>
    <div class="stat-info">
      <h3>Status Database</h3>
      <p class="status-online">Terhubung</p>
      <span class="stat-label">PostgreSQL Aktif</span>
    </div>
  </article>
</section>

<div class="section-header">
  <h2>⚡ Aksi Cepat</h2>
  <p>Akses fitur utama dengan satu klik</p>
</div>

<section class="quick-actions">
  <a href="<?= baseUrl() ?>Seni/list.php" class="action-card">
    <div class="action-icon">📋</div><h4>Lihat Daftar Seni</h4>
    <p>Kelola semua divisi seni yang terdaftar</p><span class="action-arrow">→</span>
  </a>
  <a href="<?= baseUrl() ?>Anggota/list.php" class="action-card">
    <div class="action-icon">📇</div><h4>Lihat Daftar Anggota</h4>
    <p>Kelola data seluruh anggota organisasi</p><span class="action-arrow">→</span>
  </a>
  <a href="<?= baseUrl() ?>Seni/tambah.php" class="action-card">
    <div class="action-icon">➕</div><h4>Tambah Divisi Baru</h4>
    <p>Buat divisi seni baru untuk organisasi</p><span class="action-arrow">→</span>
  </a>
  <a href="<?= baseUrl() ?>Anggota/tambah.php" class="action-card">
    <div class="action-icon">🆕</div><h4>Tambah Anggota Baru</h4>
    <p>Daftarkan anggota baru ke dalam sistem</p><span class="action-arrow">→</span>
  </a>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>