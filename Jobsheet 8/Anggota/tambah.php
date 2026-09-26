<?php
require_once __DIR__ . '/../includes/init.php';

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$isEdit = $editId > 0;
$errors = [];
$data   = ['nama' => '', 'no_anggota' => '', 'alamat' => '', 'no_hp' => ''];

// Ambil data jika mode edit
if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $row = $stmt->fetch();
    if ($row) {
        $data = $row;
    } else {
        setFlash('error', 'Data anggota tidak ditemukan.');
        header('Location: list.php');
        exit;
    }
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nama']       = trim($_POST['nama']       ?? '');
    $data['no_anggota'] = trim($_POST['no_anggota'] ?? '');
    $data['alamat']     = trim($_POST['alamat']     ?? '');
    $data['no_hp']      = trim($_POST['no_hp']      ?? '');

    if ($data['nama'] === '')       $errors[] = 'Nama lengkap wajib diisi.';
    if ($data['no_anggota'] === '') $errors[] = 'Nomor ID Anggota wajib diisi.';
    if ($data['alamat'] === '')     $errors[] = 'Alamat wajib diisi.';

    if ($data['no_hp'] === '')      $errors[] = 'No. HP / WhatsApp wajib diisi.';
    elseif (!preg_match('/^[0-9\+\-\s]{8,20}$/', $data['no_hp']))
        $errors[] = 'Format No. HP tidak valid (8-20 digit).';

    // Cek duplikasi no_anggota (kecuali dirinya sendiri saat edit)
    if (empty($errors)) {
        $sql = "SELECT COUNT(*) FROM anggota WHERE no_anggota = :no";
        $params = [':no' => $data['no_anggota']];
        if ($isEdit) {
            $sql .= " AND id != :id";
            $params[':id'] = $editId;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Nomor ID Anggota sudah digunakan.';
        }
    }

    if (empty($errors)) {
        if ($isEdit) {
            $stmt = $pdo->prepare("UPDATE anggota SET nama=:nama, no_anggota=:no_anggota, alamat=:alamat, no_hp=:no_hp, updated_at=CURRENT_TIMESTAMP WHERE id=:id");
            $stmt->execute([
                ':nama'       => $data['nama'],
                ':no_anggota' => $data['no_anggota'],
                ':alamat'     => $data['alamat'],
                ':no_hp'      => $data['no_hp'],
                ':id'         => $editId
            ]);
            setFlash('success', 'Data anggota berhasil diperbarui.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO anggota (nama, no_anggota, alamat, no_hp) VALUES (:nama, :no_anggota, :alamat, :no_hp)");
            $stmt->execute([
                ':nama'       => $data['nama'],
                ':no_anggota' => $data['no_anggota'],
                ':alamat'     => $data['alamat'],
                ':no_hp'      => $data['no_hp']
            ]);
            setFlash('success', 'Anggota baru berhasil didaftarkan.');
        }
        header('Location: list.php');
        exit;
    }
}

$page_title = $isEdit ? 'Ubah Anggota' : 'Tambah Anggota';
$activePage = 'anggota-tambah';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <div class="page-header-content">
    <span class="page-badge">👥 Formulir Anggota</span>
    <h1 class="page-title"><?= $isEdit ? 'Ubah Data Anggota' : 'Registrasi Anggota Baru' ?></h1>
    <p class="page-subtitle">Isi data anggota dengan lengkap dan benar.</p>
  </div>
  <a href="list.php" class="btn-back"><span>←</span> Kembali ke Daftar</a>
</div>

<?php if (!empty($errors)): ?>
  <div class="flash flash-error">
    <span class="flash-icon">⚠️</span>
    <div class="flash-text">
      <strong>Terjadi kesalahan:</strong>
      <ul style="margin: 0.5rem 0 0 1.25rem;">
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<div class="form-grid">
  <section class="form-card">
    <div class="form-card-header">
      <div class="form-card-icon">📝</div>
      <div>
        <h2><?= $isEdit ? 'Edit Data Anggota' : 'Data Anggota' ?></h2>
        <p>Semua kolom bertanda <span class="required-mark">*</span> wajib diisi</p>
      </div>
    </div>

    <form method="POST">
      <div class="form-group">
        <label for="nama"><span class="label-icon">👤</span> Nama Lengkap <span class="required-mark">*</span></label>
        <input type="text" id="nama" name="nama" placeholder="Contoh: Budi Santoso" value="<?= e($data['nama']) ?>" required />
      </div>
      <div class="form-group">
        <label for="no_anggota"><span class="label-icon">🆔</span> Nomor ID Anggota <span class="required-mark">*</span></label>
        <input type="text" id="no_anggota" name="no_anggota" placeholder="Contoh: A-001" value="<?= e($data['no_anggota']) ?>" required />
      </div>
      <div class="form-group">
        <label for="alamat"><span class="label-icon">📍</span> Alamat Domisili <span class="required-mark">*</span></label>
        <input type="text" id="alamat" name="alamat" placeholder="Contoh: Jakarta Selatan" value="<?= e($data['alamat']) ?>" required />
      </div>
      <div class="form-group">
        <label for="no_hp"><span class="label-icon">📱</span> No. Handphone / WhatsApp <span class="required-mark">*</span></label>
        <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789" value="<?= e($data['no_hp']) ?>" required />
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-submit"><span>💾</span> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Data Anggota' ?></button>
        <a href="list.php" class="btn-reset" style="text-decoration:none;"><span>↩️</span> Batal</a>
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
      <div class="info-icon info-icon-blue">🗄️</div>
      <h3>Database</h3>
      <p class="info-stat">Total Anggota Tersimpan:</p>
      <p class="info-stat-value"><?= $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn() ?></p>
      <a href="list.php" class="info-link">Lihat semua anggota →</a>
    </div>
    <div class="info-card info-card-gradient">
      <div class="info-icon info-icon-white">🎭</div>
      <h3>Seni Theatrisic</h3>
      <p>Satu langkah kecil untuk kemajuan seni dan budaya Indonesia.</p>
    </div>
  </aside>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>