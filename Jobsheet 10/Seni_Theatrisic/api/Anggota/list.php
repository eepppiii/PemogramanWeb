<?php
// api/Anggota/list.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Daftar Anggota';
$activePage = 'anggota';

$stmt = $pdo->query("SELECT * FROM anggota ORDER BY id DESC");
$dataAnggota = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">👥 Manajemen Data</span>
        <h1 class="page-title">Daftar Anggota Organisasi</h1>
        <p class="page-subtitle">Kelola seluruh data anggota yang terdaftar.</p>
    </div>
    <a href="<?= appUrl('Anggota/tambah.php') ?>" class="btn-add">➕ Tambah Anggota Baru</a>
</section>

<section class="table-section">
    <div class="table-header">
        <div class="table-header-left">
            <h2>📇 Data Anggota</h2>
            <p>Total: <?= count($dataAnggota) ?> anggota</p>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. ID</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat / Domisili</th>
                    <th>No. WhatsApp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataAnggota)): ?>
                    <tr><td colspan="5" style="text-align:center;">Belum ada data.</td></tr>
                <?php else: ?>
                    <?php foreach ($dataAnggota as $a): ?>
                        <tr>
                            <td><b><?= e($a['no_anggota']) ?></b></td>
                            <td><?= e($a['nama']) ?></td>
                            <td><?= e($a['alamat']) ?></td>
                            <td><?= e($a['no_hp']) ?></td>
                            <td>
                                <!-- PERBAIKAN: Gunakan appUrl() -->
                                <a href="<?= appUrl('Anggota/tambah.php?id=' . $a['id']) ?>" class="btn-edit">✏️ Ubah</a>
                                <form method="POST" action="<?= appUrl('Anggota/hapus.php') ?>" class="form-delete" onsubmit="return confirm('Yakin hapus data ini?')">
                                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
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