<?php
require_once __DIR__ . '/../includes/init.php';

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$isEdit = $editId > 0;
$errors = [];
$data   = ['no_divisi' => '', 'nama_divisi' => '', 'keterangan' => '', 'tahun' => ''];

if ($isEdit) {
    $index = cariIndexById($_SESSION['seni'], $editId);
    if ($index >= 0) {
        $data = $_SESSION['seni'][$index];
    } else {
        setFlash('error', 'Data divisi tidak ditemukan.');
        header('Location: list.php');
        exit;
    }
}

// ============ PROSES FORM (SERVER-SIDE VALIDATION) ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['no_divisi']   = trim($_POST['no_divisi']   ?? '');
    $data['nama_divisi'] = trim($_POST['nama_divisi'] ?? '');
    $data['keterangan']  = trim($_POST['keterangan']  ?? '');
    $data['tahun']       = trim($_POST['tahun']       ?? '');

    if ($data['no_divisi'] === '')            $errors[] = 'Nomor divisi wajib diisi.';
    elseif (!ctype_digit($data['no_divisi'])) $errors[] = 'Nomor divisi harus berupa angka.';

    if ($data['nama_divisi'] === '')          $errors[] = 'Nama divisi wajib diisi.';
    if ($data['keterangan'] === '')           $errors[] = 'Keterangan wajib diisi.';

    if ($data['tahun'] === '')                $errors[] = 'Tahun wajib diisi.';
    elseif (!ctype_digit($data['tahun']) || (int)$data['tahun'] < 1900 || (int)$data['tahun'] > 2100)
        $errors[] = 'Tahun harus di antara 1900–2100.';

    if (empty($errors)) {
        if ($isEdit) {
            $_SESSION['seni'][$index] = [
                'id'          => $editId,
                'no_divisi'   => $data['no_divisi'],
                'nama_divisi' => $data['nama_divisi'],
                'keterangan'  => $data['keterangan'],
                'tahun'       => $data['tahun'],
            ];
            setFlash('success', 'Data divisi seni berhasil diperbarui.');
        } else {
            $_SESSION['seni'][] = [
                'id'          => round(microtime(true) * 1000),
                'no_divisi'   => $data['no_divisi'],
                'nama_divisi' => $data['nama_divisi'],
                'keterangan'  => $data['keterangan'],
                'tahun'       => $data['tahun'],
            ];
            setFlash('success', 'Divisi seni baru berhasil ditambahkan.');
        }
        header('Location: list.php');
        exit;
    }
}

$page_title = $isEdit ? 'Ubah Divisi Seni' : 'Tambah Seni';
$activePage = 'seni-tambah';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <div class="page-header-content">
    <span class="page-badge">🎭 Formulir Divisi</span>
    <h1 class="page-title"><?= $isEdit ? 'Ubah Divisi Seni' : 'Registrasi Divisi Seni Baru' ?></h1>
    <p class="page-subtitle">Isi data divisi seni dengan lengkap dan benar.</p>
  </div>
  <a href="list.php" class="btn-back"><span>←</span> Kembali ke Daftar</a>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-error">
    <span>⚠️</span>
    <div>
      <strong>Terjadi kesalahan:</strong>
      <ul style="margin: 0.5rem 0 0 1.25rem;">
        <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<div class="form-grid">
  <section class="form-card">
    <div class="form-card-header">
      <div class="form-card-icon">🎭</div>
      <div>
        <h2><?= $isEdit ? 'Edit Data Divisi' : 'Data Divisi Seni' ?></h2>
        <p>Semua kolom bertanda <span class="required-mark">*</span> wajib diisi</p>
      </div>
    </div>

    <form method="POST">
      <div class="form-group">
        <label for="no_divisi"><span class="label-icon">🔢</span> Nomor Divisi <span class="required-mark">*</span></label>
        <input type="text" id="no_divisi" name="no_divisi" placeholder="Contoh: 1" value="<?= e($data['no_divisi']) ?>" required />
      </div>
      <div class="form-group">
        <label for="nama_divisi"><span class="label-icon">🎨</span> Nama Divisi <span class="required-mark">*</span></label>
        <input type="text" id="nama_divisi" name="nama_divisi" placeholder="Contoh: Teater Utama" value="<?= e($data['nama_divisi']) ?>" required />
      </div>
      <div class="form-group">
        <label for="keterangan"><span class="label-icon">📝</span> Deskripsi / Keterangan <span class="required-mark">*</span></label>
        <input type="text" id="keterangan" name="keterangan" placeholder="Contoh: Divisi pementasan drama modern" value="<?= e($data['keterangan']) ?>" required />
      </div>
      <div class="form-group">
        <label for="tahun"><span class="label-icon">📅</span> Tahun Berdiri <span class="required-mark">*</span></label>
        <input type="text" id="tahun" name="tahun" placeholder="Contoh: 2024" value="<?= e($data['tahun']) ?>" required />
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-submit"><span>💾</span> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Data Seni' ?></button>
        <a href="list.php" class="btn-reset" style="text-decoration:none;"><span>↩️</span> Batal</a>
      </div>
    </form>
  </section>

  <aside class="info-panel">
    <div class="info-card">
      <div class="info-icon info-icon-purple">💡</div>
      <h3>Tips Pengisian</h3>
      <ul class="info-list">
        <li>Nomor divisi harus unik, contoh: <code>1</code></li>
        <li>Gunakan nama divisi yang jelas &amp; singkat</li>
        <li>Keterangan maksimal 2–3 kalimat</li>
        <li>Tahun berdiri sesuai tahun pembentukan</li>
      </ul>
    </div>
    <div class="info-card">
      <div class="info-icon info-icon-blue">📊</div>
      <h3>Statistik</h3>
      <p class="info-stat">Total Divisi Terdaftar:</p>
      <p class="info-stat-value"><?= count($_SESSION['seni']) ?></p>
      <a href="list.php" class="info-link">Lihat semua divisi →</a>
    </div>
    <div class="info-card info-card-gradient">
      <div class="info-icon info-icon-white">✨</div>
      <h3>Seni Theatrisic</h3>
      <p>Setiap divisi adalah pilar penting bagi kemajuan seni dan budaya organisasi.</p>
    </div>
  </aside>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>