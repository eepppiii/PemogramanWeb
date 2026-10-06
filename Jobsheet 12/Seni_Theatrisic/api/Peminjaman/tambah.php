<?php
// api/peminjaman/tambah.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Peminjaman Baru';
$activePage = 'peminjaman';

// Ambil data anggota
$anggota = $pdo->query("SELECT * FROM anggota ORDER BY nama ASC")->fetchAll();
// Ambil data seni yang stoknya > 0
$seni = $pdo->query("SELECT * FROM seni WHERE stok > 0 ORDER BY nama_divisi ASC")->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">📚 Transaksi</span>
        <h1 class="page-title">Peminjaman Baru</h1>
        <p class="page-subtitle">Pilih anggota dan divisi seni yang akan dipinjam.</p>
    </div>
    <a href="<?= appUrl('peminjaman/riwayat.php') ?>" class="btn-back">← Riwayat</a>
</section>

<section class="form-card">
    <form method="POST" action="<?= appUrl('peminjaman/proses_tambah.php') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Pilih Anggota <span class="required-mark">*</span></label>
            <select name="id_anggota" required style="width:100%; padding:0.85rem; border-radius:8px; border:1px solid #cbd5e1;">
                <option value="">-- Pilih Anggota --</option>
                <?php foreach ($anggota as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= e($a['nama']) ?> (<?= e($a['no_anggota']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Pilih Divisi Seni <span class="required-mark">*</span></label>
            <select name="id_seni" required style="width:100%; padding:0.85rem; border-radius:8px; border:1px solid #cbd5e1;">
                <option value="">-- Pilih Seni --</option>
                <?php foreach ($seni as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= e($s['nama_divisi']) ?> - Stok: <?= $s['stok'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">💾 Simpan Peminjaman</button>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>