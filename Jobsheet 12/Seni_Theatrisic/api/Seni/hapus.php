<?php
// api/Seni/hapus.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    
    // ==========================================
    // INI DIA PROTEKSI CSRF-NYA (Sesuai Jobsheet)
    // ==========================================
    // Jika form dikirim dari situs jahat (seperti di contoh dokumentasi),
    // tokennya tidak akan cocok, dan script ini akan mati di sini.
    csrf_verify(); 

    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM seni WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: " . appUrl('Seni/list.php'));
exit;
?>