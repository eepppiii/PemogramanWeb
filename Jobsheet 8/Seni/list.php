<?php
require_once __DIR__ . '/../includes/init.php';

$page_title = 'Daftar Seni';
$activePage = 'seni-list';

$stmt = $pdo->query("SELECT * FROM seni ORDER BY id DESC");
$dataSeni = $stmt->fetchAll();
$totalSeni = count($dataSeni);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <div class="page-header-content">
    <span class="page-badge">📋 Manajemen Data</span>
    <h1 class="page-title">Daftar Divisi Seni</h1>
    <p class="page-subtitle">Kelola seluruh divisi seni yang terdaftar dalam organisasi Seni Theatrisic.</p>
  </div>
  <a href="tambah.php" class="btn-add"><span>➕</span> Tambah Divisi Baru</a>
</div>

<div class="mini-stats">
  <div class="mini-stat">
    <span class="mini-stat-icon">🎭</span>
    <div>
      <p class="mini-stat-label">Total Divisi</p>
      <p class="mini-stat-value"><?= $totalSeni ?></p>
    </div>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-icon">🐘</span>
    <div>
      <p class="mini-stat-label">Database</p>
      <p class="mini-stat-value-small">PostgreSQL</p>
    </div>
  </div>
</div>

<section class="table-section">
  <div class="table-header">
    <div class="table-header-left">
      <h2>📋 Data Divisi Seni</h2>
      <p>Kelola dan cari divisi seni dengan mudah</p>
    </div>
    <div class="search-wrapper">
      <span class="search-icon">🔍</span>
      <input type="text" id="search-seni" placeholder="Cari divisi, keterangan, atau tahun..." onkeyup="cariSeni()">
    </div>
  </div>

  <div class="table-responsive">
    <table id="tabel-seni">
      <thead>
        <tr>
          <th>No. Divisi</th>
          <th>Nama Divisi</th>
          <th>Keterangan</th>
          <th>Tahun</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($totalSeni === 0): ?>
          <tr>
            <td colspan="5" style="text-align:center; padding:2rem;">
              Belum ada divisi seni yang terdaftar.<br>
              <a href="tambah.php">Tambahkan divisi pertama</a>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($dataSeni as $item): ?>
            <tr data-row>
              <td><?= e($item['no_divisi']) ?></td>
              <td><b><?= e($item['nama_divisi']) ?></b></td>
              <td><?= e($item['keterangan']) ?></td>
              <td><?= e($item['tahun']) ?></td>
              <td>
                <a href="tambah.php?edit=<?= $item['id'] ?>" class="btn-edit" style="text-decoration:none; display:inline-block;">✏️ Ubah</a>
                <button type="button" onclick="askDelete('hapus.php?id=<?= $item['id'] ?>', '<?= e(addslashes($item['nama_divisi'])) ?>')">🗑️ Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<script>
function cariSeni() {
  const q = document.getElementById('search-seni').value.toLowerCase();
  document.querySelectorAll('#tabel-seni tbody tr[data-row]').forEach(tr => {
    tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
  });
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>