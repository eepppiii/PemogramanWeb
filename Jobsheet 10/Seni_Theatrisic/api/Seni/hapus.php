<?php
// api/Seni/hapus.php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $pdo->prepare("DELETE FROM seni WHERE id = :id");
    $stmt->execute(['id' => $_POST['id']]);
}

// REDIRECT ABSOLUT
header("Location: " . appUrl('Seni/list.php'));
exit;
?>