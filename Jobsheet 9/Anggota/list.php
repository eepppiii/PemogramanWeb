<?php
require_once __DIR__ . '/../includes/init.php';

$page_title = 'Daftar Anggota';
$activePage = 'anggota-list';

$limit  = 5;
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :search OR no_anggota ILIKE :search OR alamat ILIKE :search OR no_hp ILIKE :search");
    $countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
} else {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM anggota");
}
$countStmt->execute();
$totalData  = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalData / $limit);

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM anggota 
                            WHERE nama ILIKE :search 
                               OR no_anggota ILIKE :search 
                               OR alamat ILIKE :search 
                               OR no_hp ILIKE :search
                            ORDER BY id DESC 
                            LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$dataAnggota = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <div class="page-header-content">
    <span class="page-badge">👥 Manajemen Data</span>
    <h1 class="page-title">Daftar Anggota Organisasi</h1>
    <p class="page-subtitle">Kelola seluruh data anggota yang terdaftar.</p>
  </div>
  <a href="tambah.php" class="btn-add"><span>➕</span> Tambah Anggota Baru</a>
</div>

<section class="table-section">
  <div class="table-header">
    <div class="table-header-left">
      <h2>📇 Data Anggota</h2>
      <p>Total: <b><?= $totalData ?></b> anggota
         <?php if ($search): ?>
           | Hasil pencarian: "<b><?= e($search) ?></b>"
         <?php endif; ?>
      </p>
    </div>
    <form method="get" class="search-wrapper">
      <span class="search-icon">🔍</span>
      <input type="text" name="search" placeholder="Cari nama, nomor anggota, atau domisili..." 
             value="<?= e($search) ?>">
      <button type="submit" style="display:none;">Cari</button>
    </form>
  </div>

  <div class="table-responsive">
    <table id="tabel-anggota">
      <thead>
        <tr>
          <th>No. ID</th><th>Nama Lengkap</th><th>Alamat / Domisili</th><th>No. WhatsApp</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($dataAnggota)): ?>
          <tr><td colspan="5" style="text-align:center; padding:2rem;">
            <?= $search ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada anggota.' ?>
          </td></tr>
        <?php else: ?>
          <?php foreach ($dataAnggota as $item): ?>
            <tr data-row>
              <td><?= e($item['no_anggota']) ?></td>
              <td><b><?= e($item['nama']) ?></b></td>
              <td><?= e($item['alamat']) ?></td>
              <td><?= e($item['no_hp']) ?></td>
              <td>
                <a href="tambah.php?edit=<?= $item['id'] ?>" class="btn-edit">✏️ Ubah</a>
                <form method="post" action="hapus.php" class="form-delete" 
                      onsubmit="return konfirmasiHapus(event, '<?= e(addslashes($item['nama'])) ?>')">
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

  <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="page-link">← Prev</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
           class="page-link <?= $i === $page ? 'active' : '' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="page-link">Next →</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>

<script>
function konfirmasiHapus(event, label) {
  event.preventDefault();
  const form = event.target;
  if (confirm('Hapus data "' + label + '"? Data yang sudah dihapus tidak bisa dikembalikan.')) {
    form.submit();
  }
  return false;
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>