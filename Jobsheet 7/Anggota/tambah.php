<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Anggota | Seni Theatrisic</title>
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
        <span class="page-badge">👥 Formulir Anggota</span>
        <h1 class="page-title">Registrasi Anggota Baru</h1>
        <p class="page-subtitle">Isi data anggota dengan lengkap dan benar.</p>
      </div>
      <a href="list.html" class="btn-back"><span>←</span> Kembali ke Daftar</a>
    </div>

    <div class="form-grid">
      <section class="form-card">
        <div class="form-card-header">
          <div class="form-card-icon">📝</div>
          <div>
            <h2>Data Anggota</h2>
            <p>Semua kolom bertanda <span class="required-mark">*</span> wajib diisi</p>
          </div>
        </div>

        <form id="form-anggota" onsubmit="simpanAnggota(event)">
          <div class="form-group">
            <label for="nama"><span class="label-icon">👤</span> Nama Lengkap <span class="required-mark">*</span></label>
            <input type="text" id="nama" placeholder="Contoh: Budi Santoso" required />
          </div>
          <div class="form-group">
            <label for="no_anggota"><span class="label-icon">🆔</span> Nomor ID Anggota <span class="required-mark">*</span></label>
            <input type="text" id="no_anggota" placeholder="Contoh: A-001" required />
          </div>
          <div class="form-group">
            <label for="alamat"><span class="label-icon">📍</span> Alamat Domisili <span class="required-mark">*</span></label>
            <input type="text" id="alamat" placeholder="Contoh: Jakarta Selatan" required />
          </div>
          <div class="form-group">
            <label for="no_hp"><span class="label-icon">📱</span> No. Handphone / WhatsApp <span class="required-mark">*</span></label>
            <input type="text" id="no_hp" placeholder="Contoh: 08123456789" required />
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-submit"><span>💾</span> Simpan Data Anggota</button>
            <button type="reset" class="btn-reset"><span>🔄</span> Reset</button>
          </div>
        </form>
      </section>

      <aside class="info-panel">
        <div class="info-card">
          <div class="info-icon info-icon-purple">💡</div>
          <h3>Tips Pengisian</h3>
          <ul class="info-list">
            <li>Gunakan nama lengkap sesuai identitas resmi</li>
            <li>Nomor ID unik, contoh: <code>A-001</code></li>
            <li>Tulis alamat domisili minimal kota/kabupaten</li>
            <li>Nomor WA aktif untuk komunikasi organisasi</li>
          </ul>
        </div>
        <div class="info-card">
          <div class="info-icon info-icon-blue">📊</div>
          <h3>Statistik</h3>
          <p class="info-stat">Total Anggota Terdaftar:</p>
          <p class="info-stat-value" id="total-anggota-info">0</p>
          <a href="list.html" class="info-link">Lihat semua anggota →</a>
        </div>
        <div class="info-card info-card-gradient">
          <div class="info-icon info-icon-white">🎭</div>
          <h3>Seni Theatrisic</h3>
          <p>Satu langkah kecil untuk kemajuan seni dan budaya Indonesia.</p>
        </div>
      </aside>
    </div>
  </main>

  <footer>
    <p>&copy; 2026 <strong>Seni Theatrisic</strong> &mdash; Sistem Manajemen Organisasi</p>
    <p class="footer-sub">Dibuat dengan ❤️ untuk kemajuan seni</p>
  </footer>

  <div id="toast-stack" class="toast-stack"></div>
  <script src="../assets/js/script.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var data = JSON.parse(localStorage.getItem("data_anggota_v2") || "[]");
      var el = document.getElementById("total-anggota-info");
      if (el) el.textContent = data.length;
    });
  </script>
</body>
</html>