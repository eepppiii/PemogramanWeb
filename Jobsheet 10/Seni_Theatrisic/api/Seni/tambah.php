<?php
// api/Seni/tambah.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Tambah Seni';
$activePage = 'seni';

$id = $_GET['id'] ?? null;
$data = ['no_divisi' => '', 'nama_divisi' => '', 'keterangan' => '', 'tahun' => ''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM seni WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch() ?: $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_divisi   = $_POST['no_divisi'];
    $nama_divisi = $_POST['nama_divisi'];
    $keterangan  = $_POST['keterangan'];
    $tahun       = $_POST['tahun'];

    if ($id) {
        $sql = "UPDATE seni SET no_divisi=:no_divisi, nama_divisi=:nama_divisi, keterangan=:keterangan, tahun=:tahun WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(compact('no_divisi', 'nama_divisi', 'keterangan', 'tahun', 'id'));
    } else {
        $sql = "INSERT INTO seni (no_divisi, nama_divisi, keterangan, tahun) VALUES (:no_divisi, :nama_divisi, :keterangan, :tahun)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(compact('no_divisi', 'nama_divisi', 'keterangan', 'tahun'));
    }
    
    // REDIRECT ABSOLUT (Anti Gagal)
    header("Location: " . appUrl('Seni/list.php'));
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">🎭 Form Seni</span>
        <h1 class="page-title"><?= $id ? 'Ubah' : 'Tambah' ?> Divisi Seni</h1>
        <p class="page-subtitle">Isi formulir di bawah ini dengan lengkap.</p>
    </div>
    <a href="<?= appUrl('Seni/list.php') ?>" class="btn-back">← Kembali</a>
</section>

<section class="form-card">
    <!-- ACTION FORM ABSOLUT -->
    <form method="POST" action="<?= appUrl('Seni/tambah.php' . ($id ? '?id=' . $id : '')) ?>">
        <div class="form-group">
            <label>No Divisi <span class="required-mark">*</span></label>
            <input type="text" name="no_divisi" value="<?= e($data['no_divisi']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nama Divisi <span class="required-mark">*</span></label>
            <input type="text" name="nama_divisi" value="<?= e($data['nama_divisi']) ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan <span class="required-mark">*</span></label>
            <input type="text" name="keterangan" value="<?= e($data['keterangan']) ?>" required>
        </div>
        <div class="form-group">
            <label>Tahun <span class="required-mark">*</span></label>
            <input type="text" name="tahun" value="<?= e($data['tahun']) ?>" maxlength="4" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">💾 Simpan Data</button>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>