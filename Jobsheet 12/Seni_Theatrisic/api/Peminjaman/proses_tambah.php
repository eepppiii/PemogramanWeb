<?php
// api/peminjaman/proses_tambah.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . appUrl('peminjaman/tambah.php'));
    exit;
}

csrf_verify();

$id_anggota = $_POST['id_anggota'];
$id_seni    = $_POST['id_seni'];

try {
    $pdo->beginTransaction();

    // Ambil stok dengan FOR UPDATE untuk mencegah race condition
    $stmt = $pdo->prepare("SELECT stok FROM seni WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $id_seni]);
    $seni = $stmt->fetch();

    if (!$seni || $seni['stok'] <= 0) {
        throw new Exception("Stok tidak tersedia!");
    }

    // Kurangi stok
    $pdo->prepare("UPDATE seni SET stok = stok - 1 WHERE id = :id")->execute(['id' => $id_seni]);

    // Simpan transaksi peminjaman
    $stmt = $pdo->prepare("INSERT INTO peminjaman (id_anggota, id_seni, status) VALUES (:id_anggota, :id_seni, 'dipinjam')");
    $stmt->execute(['id_anggota' => $id_anggota, 'id_seni' => $id_seni]);

    $pdo->commit();
    $_SESSION['success'] = "Peminjaman berhasil dicatat!";
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Gagal memproses peminjaman: " . $e->getMessage();
}

header("Location: " . appUrl('peminjaman/kembali.php'));
exit;
?>