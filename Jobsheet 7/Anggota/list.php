<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Anggota | Seni Theatrisic</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header>
    <h1><span>🎭</span> Seni Theatrisic</h1>
    <input type="checkbox" id="menu-toggle" class="menu-checkbox" style="display:none;"/>
    <label for="menu-toggle" class="hamburger-icon">&#9776;</label>
    <nav>
      <ul>
        <li><a href="../index.html">Beranda</a></li>
        <li><a href="../Seni/list.html">Daftar Seni</a></li>
        <li><a href="../Seni/tambah.html">Tambah Seni</a></li>
        <li><a href="list.html">Daftar Anggota</a></li>
        <li><a href="tambah.html">Tambah Anggota</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div id="flash-container"></div>

    <div class="page-header">
      <div class="page-header-content">
        <span class="page-badge">👥 Manajemen Data</span>
        <h1 class="page-title">Daftar Anggota Organisasi</h1>
        <p class="page-subtitle">Kelola seluruh data anggota yang terdaftar dalam sistem Seni Theatrisic.</p>
      </div>
      <a href="tambah.html" class="btn-add"><span>➕</span> Tambah Anggota Baru</a>
    </div>

    <div class="mini-stats">
      <div class="mini-stat">
        <span class="mini-stat-icon">👥</span>
        <div>
          <p class="mini-stat-label">Total Anggota</p>
          <p class="mini-stat-value" id="total-anggota">0</p>
        </div>
      </div>
      <div class="mini-stat">
        <span class="mini-stat-icon">✅</span>
        <div>
          <p class="mini-stat-label">Status</p>
          <p class="mini-stat-value-small">Terdaftar</p>
        </div>
      </div>
    </div>

    <section class="table-section">
      <div class="table-header">
        <div class="table-header-left">
          <h2>📇 Data Anggota</h2>
          <p>Kelola dan cari data anggota dengan mudah</p>
        </div>
        <div class="search-wrapper">
          <span class="search-icon">🔍</span>
          <input type="text" id="search-anggota" placeholder="Cari nama, nomor anggota, atau domisili..." onkeyup="cariAnggota()">
        </div>
      </div>

      <div class="table-responsive">
        <table id="tabel-anggota">
          <thead>
            <tr>
              <th>No. ID</th><th>Nama Lengkap</th><th>Alamat / Domisili</th><th>No. WhatsApp</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
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

  <script src="../assets/js/script.js"></script>
</body>
</html>