<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('error', 'Metode tidak valid. Hapus data harus via POST.');
    header('Location: list.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
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