<?php
// api/peminjaman/proses_kembali.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_peminjaman'])) {
    header("Location: " . appUrl('peminjaman/kembali.php'));
    exit;
}

csrf_verify();

$id_peminjaman = $_POST['id_peminjaman'];

try {
    $pdo->beginTransaction();

    // Ambil data peminjaman
    $stmt = $pdo->prepare("SELECT id_seni FROM peminjaman WHERE id = :id AND status = 'dipinjam' FOR UPDATE");
    $stmt->execute(['id' => $id_peminjaman]);
    $peminjaman = $stmt->fetch();

    if (!$peminjaman) {
        throw new Exception("Transaksi tidak ditemukan atau sudah dikembalikan.");
    }

    // Update status peminjaman
    $pdo->prepare("UPDATE peminjaman SET status = 'kembali', tanggal_kembali = CURRENT_DATE WHERE id = :id")
        ->execute(['id' => $id_peminjaman]);

    // Tambah stok kembali
    $pdo->prepare("UPDATE seni SET stok = stok + 1 WHERE id = :id_seni")
        ->execute(['id_seni' => $peminjaman['id_seni']]);

    $pdo->commit();
    $_SESSION['success'] = "Buku/Seni berhasil dikembalikan!";
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Gagal memproses pengembalian: " . $e->getMessage();
}

header("Location: " . appUrl('peminjaman/kembali.php'));
exit;
?>