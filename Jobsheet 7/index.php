<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Seni Theatrisic</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header>
    <h1><span>🎭</span> Seni Theatrisic</h1>
    <input type="checkbox" id="menu-toggle" class="menu-checkbox" style="display:none;"/>
    <label for="menu-toggle" class="hamburger-icon">&#9776;</label>
    <nav>
      <ul>
        <li><a href="index.html">Beranda</a></li>
        <li><a href="Seni/list.html">Daftar Seni</a></li>
        <li><a href="Seni/tambah.html">Tambah Seni</a></li>
        <li><a href="Anggota/list.html">Daftar Anggota</a></li>
        <li><a href="Anggota/tambah.html">Tambah Anggota</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div id="flash-container"></div>

    <section class="hero-section">
      <div class="hero-content">
        <span class="hero-badge">✨ Portal Admin</span>
        <h1 class="hero-title">Selamat Datang di <br><span class="gradient-text">Seni Theatrisic</span></h1>
        <p class="hero-subtitle">Kelola divisi seni dan data keanggotaan organisasi dengan mudah, cepat, dan menyenangkan. Semua data tersimpan rapi di satu tempat.</p>
        <div class="hero-actions">
          <a href="Seni/tambah.html" class="btn-primary"><span>➕</span> Tambah Divisi Seni</a>
          <a href="Anggota/tambah.html" class="btn-secondary"><span>👥</span> Daftarkan Anggota</a>
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
          <p id="total-seni">0</p>
          <span class="stat-label">Divisi Aktif</span>
        </div>
      </article>
      <article class="stat-card">
        <div class="stat-icon stat-icon-blue">👥</div>
        <div class="stat-info">
          <h3>Total Anggota</h3>
          <p id="total-anggota">0</p>
          <span class="stat-label">Anggota Terdaftar</span>
        </div>
      </article>
      <article class="stat-card">
        <div class="stat-icon stat-icon-green">📈</div>
        <div class="stat-info">
          <h3>Status Sistem</h3>
          <p class="status-online">Aktif</p>
          <span class="stat-label">Berjalan Normal</span>
        </div>
      </article>
    </section>

    <div class="section-header">
      <h2>⚡ Aksi Cepat</h2>
      <p>Akses fitur utama dengan satu klik</p>
    </div>

    <section class="quick-actions">
      <a href="Seni/list.html" class="action-card">
        <div class="action-icon">📋</div><h4>Lihat Daftar Seni</h4>
        <p>Kelola semua divisi seni yang terdaftar</p><span class="action-arrow">→</span>
      </a>
      <a href="Anggota/list.html" class="action-card">
        <div class="action-icon">📇</div><h4>Lihat Daftar Anggota</h4>
        <p>Kelola data seluruh anggota organisasi</p><span class="action-arrow">→</span>
      </a>
      <a href="Seni/tambah.html" class="action-card">
        <div class="action-icon">➕</div><h4>Tambah Divisi Baru</h4>
        <p>Buat divisi seni baru untuk organisasi</p><span class="action-arrow">→</span>
      </a>
      <a href="Anggota/tambah.html" class="action-card">
        <div class="action-icon">🆕</div><h4>Tambah Anggota Baru</h4>
        <p>Daftarkan anggota baru ke dalam sistem</p><span class="action-arrow">→</span>
      </a>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 <strong>Seni Theatrisic</strong> &mdash; Sistem Manajemen Organisasi</p>
    <p class="footer-sub">Dibuat dengan ❤️ untuk kemajuan seni</p>
  </footer>

  <div id="toast-stack" class="toast-stack"></div>
  <div id="confirm-modal" class="modal-overlay">
      <div class="modal-box">
          <p id="confirm-modal-text">Yakin ingin menghapus data ini?</p>
          <div class="modal-actions">
              <button type="button" class="btn-cancel" onclick="closeConfirm()">Batal</button>
              <button type="button" class="btn-danger" onclick="confirmDelete()">Hapus</button>
          </div>
      </div>
  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>