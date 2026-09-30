<?php
// api/Seni/list.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Daftar Seni';
$activePage = 'seni';

$stmt = $pdo->query("SELECT * FROM seni ORDER BY id DESC");
$dataSeni = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">🎭 Manajemen Seni</span>
        <h1 class="page-title">Daftar Divisi Seni</h1>
        <p class="page-subtitle">Kelola semua divisi seni yang terdaftar di organisasi.</p>
    </div>
    <!-- PERBAIKAN: Gunakan appUrl() -->
    <a href="<?= appUrl('Seni/tambah.php') ?>" class="btn-add">➕ Tambah Divisi</a>
</section>

<section class="table-section">
    <div class="table-header">
        <div class="table-header-left">
            <h2>📋 Data Seni</h2>
            <p>Total: <?= count($dataSeni) ?> divisi</p>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Divisi</th>
                    <th>Nama Divisi</th>
                    <th>Keterangan</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataSeni)): ?>
                    <tr><td colspan="6" style="text-align:center;">Belum ada data.</td></tr>
                <?php else: ?>
                    <?php foreach ($dataSeni as $i => $s): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($s['no_divisi']) ?></td>
                            <td><b><?= e($s['nama_divisi']) ?></b></td>
                            <td><?= e($s['keterangan']) ?></td>
                            <td><?= e($s['tahun']) ?></td>
                            <td>
                                <!-- PERBAIKAN: Gunakan appUrl() untuk Ubah -->
                                <a href="<?= appUrl('Seni/tambah.php?id=' . $s['id']) ?>" class="btn-edit">✏️ Ubah</a>
                                
                                <!-- PERBAIKAN: Gunakan appUrl() untuk Hapus -->
                                <form method="POST" action="<?= appUrl('Seni/hapus.php') ?>" class="form-delete" onsubmit="return confirm('Yakin hapus data ini?')">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                    <button type="submit">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>