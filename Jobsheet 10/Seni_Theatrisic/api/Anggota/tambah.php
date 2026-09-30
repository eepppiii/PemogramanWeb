<?php
// api/Anggota/tambah.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Tambah Anggota';
$activePage = 'anggota';

$id = $_GET['id'] ?? null;
$data = ['nama' => '', 'no_anggota' => '', 'alamat' => '', 'no_hp' => ''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch() ?: $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = $_POST['nama'];
    $no_anggota = $_POST['no_anggota'];
    $alamat     = $_POST['alamat'];
    $no_hp      = $_POST['no_hp'];

    if ($id) {
        $sql = "UPDATE anggota SET nama=:nama, no_anggota=:no_anggota, alamat=:alamat, no_hp=:no_hp WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(compact('nama', 'no_anggota', 'alamat', 'no_hp', 'id'));
    } else {
        $sql = "INSERT INTO anggota (nama, no_anggota, alamat, no_hp) VALUES (:nama, :no_anggota, :alamat, :no_hp)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(compact('nama', 'no_anggota', 'alamat', 'no_hp'));
    }
    
    // REDIRECT ABSOLUT
    header("Location: " . appUrl('Anggota/list.php'));
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">👥 Form Anggota</span>
        <h1 class="page-title"><?= $id ? 'Ubah' : 'Tambah' ?> Anggota</h1>
        <p class="page-subtitle">Isi formulir di bawah ini dengan lengkap.</p>
    </div>
    <a href="<?= appUrl('Anggota/list.php') ?>" class="btn-back">← Kembali</a>
</section>

<section class="form-card">
    <!-- ACTION FORM ABSOLUT -->
    <form method="POST" action="<?= appUrl('Anggota/tambah.php' . ($id ? '?id=' . $id : '')) ?>">
        <div class="form-group">
            <label>No Anggota <span class="required-mark">*</span></label>
            <input type="text" name="no_anggota" value="<?= e($data['no_anggota']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nama Lengkap <span class="required-mark">*</span></label>
            <input type="text" name="nama" value="<?= e($data['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat <span class="required-mark">*</span></label>
            <input type="text" name="alamat" value="<?= e($data['alamat']) ?>" required>
        </div>
        <div class="form-group">
            <label>No HP <span class="required-mark">*</span></label>
            <input type="text" name="no_hp" value="<?= e($data['no_hp']) ?>" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">💾 Simpan Data</button>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>