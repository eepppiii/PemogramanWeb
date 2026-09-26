<?php
require_once __DIR__ . '/../includes/init.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->execute([':id' => $id]);
    if ($stmt->rowCount() > 0) {
        setFlash('success', 'Data anggota berhasil dihapus.');
    } else {
        setFlash('error', 'Data tidak ditemukan.');
    }
} else {
    setFlash('error', 'ID tidak valid.');
}

header('Location: list.php');
exit;