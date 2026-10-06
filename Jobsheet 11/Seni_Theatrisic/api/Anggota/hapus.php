<?php
// api/Anggota/hapus.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    
    // Proteksi CSRF
    csrf_verify(); 

    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: " . appUrl('Anggota/list.php'));
exit;
?>