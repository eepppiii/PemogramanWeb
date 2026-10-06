<?php
// api/peminjaman/riwayat.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Riwayat Peminjaman';
$activePage = 'riwayat';

$stmt = $pdo->query("
    SELECT p.*, a.nama AS nama_anggota, s.nama_divisi 
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN seni s ON p.id_seni = s.id
    ORDER BY p.id DESC
");
$riwayat = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="page-badge">📜 Riwayat</span>
        <h1 class="page-title">Riwayat Peminjaman</h1>
        <p class="page-subtitle">Seluruh catatan transaksi peminjaman dan pengembalian.</p>
    </div>
</section>

<section class="table-section">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Divisi Seni</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr><td colspan="6" style="text-align:center;padding:2rem;">Belum ada riwayat.</td></tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $i => $r): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($r['nama_anggota']) ?></td>
                            <td><?= e($r['nama_divisi']) ?></td>
                            <td><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></td>
                            <td><?= $r['tanggal_kembali'] ? date('d M Y', strtotime($r['tanggal_kembali'])) : '-' ?></td>
                            <td>
                                <span style="padding:0.3rem 0.8rem; border-radius:50px; font-size:0.75rem; font-weight:600; 
                                background: <?= $r['status'] === 'dipinjam' ? '#fef3c7' : '#d1fae5' ?>; 
                                color: <?= $r['status'] === 'dipinjam' ? '#d97706' : '#059669' ?>;">
                                    <?= ucfirst($r['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>