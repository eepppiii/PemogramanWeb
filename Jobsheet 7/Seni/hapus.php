<?php
require_once __DIR__ . '/../includes/init.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$index = cariIndexById($_SESSION['seni'], $id);

if ($index >= 0) {
    array_splice($_SESSION['seni'], $index, 1);
    setFlash('success', 'Data divisi seni berhasil dihapus.');
} else {
    setFlash('error', 'Data tidak ditemukan.');
}

header('Location: list.php');
exit;