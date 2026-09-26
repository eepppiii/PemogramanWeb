<?php
require_once __DIR__ . '/../includes/init.php';

$page_title = 'Daftar Seni';
$activePage = 'seni-list';

// ============================================
// KONSEP: Pagination + Pencarian Server-side
// ============================================
$limit  = 5;                                                    // Data per halaman
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; // Halaman aktif
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Hitung total data (dengan filter pencarian)
if ($search !== '') {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM seni WHERE nama_divisi ILIKE :search OR keterangan ILIKE :search OR tahun ILIKE :search");
    $countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
} else {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM seni");
}
$countStmt->execute();
$totalData  = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalData / $limit);

// Ambil data sesuai halaman + pencarian
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM seni 
                            WHERE nama_divisi ILIKE :search 
                               OR keterangan ILIKE :search 
                               OR tahun ILIKE :search
                            ORDER BY id DESC 
                            LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT * FROM seni ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);   // ⭐ PDO::PARAM_INT
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);   // ⭐ PDO::PARAM_INT
$stmt->execute();
$dataSeni = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <div class="page-header-content">
    <span class="page-badge">📋 Manajemen Data</span>
    <h1 class="page-title">Daftar Divisi Seni</h1>
    <p class="page-subtitle">Kelola seluruh divisi seni yang terdaftar.</p>
  </div>
  <a href="tambah.php" class="btn-add"><span>➕</span> Tambah Divisi Baru</a>
</div>

<!-- ============================================ -->
<!-- KONSEP: Form Pencarian dengan method="get"  -->
<!-- ============================================ -->
<section class="table-section">
  <div class="table-header">
    <div class="table-header-left">
      <h2>📋 Data Divisi Seni</h2>
      <p>Total: <b><?= $totalData ?></b> divisi 
         <?php if ($search): ?>
           | Hasil pencarian: "<b><?= e($search) ?></b>"
         <?php endif; ?>
      </p>
    </div>
    <form method="get" class="search-wrapper">
      <span class="search-icon">🔍</span>
      <input type="text" name="search" placeholder="Cari divisi, keterangan, atau tahun..." 
             value="<?= e($search) ?>">
      <button type="submit" style="display:none;">Cari</button>
    </form>
  </div>

  <div class="table-responsive">
    <table id="tabel-seni">
      <thead>
        <tr>
          <th>No. Divisi</th><th>Nama Divisi</th><th>Keterangan</th><th>Tahun</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($dataSeni)): ?>
          <tr><td colspan="5" style="text-align:center; padding:2rem;">
            <?= $search ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada divisi seni.' ?>
          </td></tr>
        <?php else: ?>
          <?php foreach ($dataSeni as $item): ?>
            <tr data-row>
              <td><?= e($item['no_divisi']) ?></td>
              <td><b><?= e($item['nama_divisi']) ?></b></td>
              <td><?= e($item['keterangan']) ?></td>
              <td><?= e($item['tahun']) ?></td>
              <td>
                <a href="tambah.php?edit=<?= $item['id'] ?>" class="btn-edit">✏️ Ubah</a>
                
                <!-- ============================================ -->
                <!-- KONSEP: Delete via POST (bukan link GET)     -->
                <!-- ============================================ -->
                <form method="post" action="hapus.php" class="form-delete" 
                      onsubmit="return konfirmasiHapus(event, '<?= e(addslashes($item['nama_divisi'])) ?>')">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <button type="submit">🗑️ Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- ============================================ -->
  <!-- KONSEP: Pagination Navigation                -->
  <!-- ============================================ -->
  <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
           class="page-link">← Prev</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
           class="page-link <?= $i === $page ? 'active' : '' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
           class="page-link">Next →</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>

<!-- ============================================ -->
<!-- KONSEP: JS Konfirmasi Hapus + preventDefault -->
<!-- ============================================ -->
<script>
function konfirmasiHapus(event, label) {
  event.preventDefault();  // ⭐ Membatalkan submit form
  const form = event.target;
  
  if (confirm('Hapus data "' + label + '"? Data yang sudah dihapus tidak bisa dikembalikan.')) {
    form.submit();  // Submit form jika user klik OK
  }
  return false;
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>