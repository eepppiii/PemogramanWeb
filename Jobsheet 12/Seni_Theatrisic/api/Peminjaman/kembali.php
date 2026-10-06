<?php
// api/peminjaman/kembali.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Pengembalian';
$activePage = 'pengembalian';

// Ambil transaksi yang masih aktif
$stmt = $pdo->query("
    SELECT p.id, a.nama AS nama_anggota, s.nama_divisi, p.tanggal_pinjam 
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN seni s ON p.id_seni = s.id
    WHERE p.status = 'dipinjam'
    ORDER BY p.tanggal_pinjam ASC
");
$transaksi = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Sukses -->
<?php if (isset($_SESSION['success'])): ?>
    <div style="background:#d1fae5; color:#065f46; padding:1rem; border-radius:8px; margin-bottom:1.5rem; border-left:4px solid #10b981; font-weight:600;">
        ✅ <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<!-- Notifikasi Error -->
<?php if (isset($_SESSION['error'])): ?>
    <div style="background:#fee2e2; color:#b91c1c; padding:1rem; border-radius:8px; margin-bottom:1.5rem; border-left:4px solid #ef4444; font-weight:600;">
        ❌ <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">🔄 Pengembalian</span>
        <h1 class="page-title">Daftar Transaksi Aktif</h1>
        <p class="page-subtitle">Kelola pengembalian divisi seni yang sedang dipinjam.</p>
    </div>
    <a href="<?= appUrl('peminjaman/tambah.php') ?>" class="btn-add">➕ Peminjaman Baru</a>
</section>

<section class="table-section">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Divisi Seni</th>
                    <th>Tgl Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transaksi)): ?>
                    <tr><td colspan="5" style="text-align:center;padding:2rem;">Tidak ada transaksi aktif.</td></tr>
                <?php else: ?>
                    <?php foreach ($transaksi as $i => $t): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($t['nama_anggota']) ?></td>
                            <td><b><?= e($t['nama_divisi']) ?></b></td>
                            <td><?= date('d M Y', strtotime($t['tanggal_pinjam'])) ?></td>
                            <td>
                                <form method="POST" action="<?= appUrl('peminjaman/proses_kembali.php') ?>" onsubmit="return confirm('Proses pengembalian ini?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_peminjaman" value="<?= $t['id'] ?>">
                                    <button type="submit" class="btn-edit" style="background:#d1fae5; color:#065f46; border:none; cursor:pointer;">✅ Kembalikan</button>
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