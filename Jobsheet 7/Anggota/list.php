<?php
require_once __DIR__ . '/../includes/init.php';
$page_title   = 'Daftar Anggota';
$activePage   = 'anggota-list';
$totalAnggota = count($_SESSION['anggota']);
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <div class="page-header-content">
    <span class="page-badge">👥 Manajemen Data</span>
    <h1 class="page-title">Daftar Anggota Organisasi</h1>
    <p class="page-subtitle">Kelola seluruh data anggota yang terdaftar dalam sistem Seni Theatrisic.</p>
  </div>
  <a href="tambah.php" class="btn-add"><span>➕</span> Tambah Anggota Baru</a>
</div>

<div class="mini-stats">
  <div class="mini-stat">
    <span class="mini-stat-icon">👥</span>
    <div>
      <p class="mini-stat-label">Total Anggota</p>
      <p class="mini-stat-value"><?= $totalAnggota ?></p>
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
      <tbody>
        <?php if ($totalAnggota === 0): ?>
          <tr><td colspan="5" style="text-align:center; padding:2rem;">Belum ada anggota yang terdaftar.<br><a href="tambah.php">Daftarkan anggota pertama</a></td></tr>
        <?php else: ?>
          <?php foreach ($_SESSION['anggota'] as $item): ?>
            <tr data-row>
              <td><?= e($item['no_anggota']) ?></td>
              <td><b><?= e($item['nama']) ?></b></td>
              <td><?= e($item['alamat']) ?></td>
              <td><?= e($item['no_hp']) ?></td>
              <td>
                <a href="tambah.php?edit=<?= $item['id'] ?>" class="btn-edit" style="text-decoration:none; display:inline-block;">✏️ Ubah</a>
                <button type="button" onclick="askDelete('hapus.php?id=<?= $item['id'] ?>', '<?= e(addslashes($item['nama'])) ?>')">🗑️ Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<script>
function cariAnggota() {
  const q = document.getElementById('search-anggota').value.toLowerCase();
  document.querySelectorAll('#tabel-anggota tbody tr[data-row]').forEach(tr => {
    tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
  });
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>