<?php
// api/auth/register.php

require_once __DIR__ . '/../includes/init.php';
// Baris require_once csrf.php SUDAH DIHAPUS karena fungsinya sudah ada di init.php

if (isset($_SESSION['user_id'])) {
    header("Location: " . appUrl('index.php'));
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifikasi CSRF Token (Fungsi ini sekarang ada di init.php)
    csrf_verify();
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');

    if (empty($username) || empty($password) || empty($nama_lengkap)) {
        $error = "Semua field wajib diisi!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            $error = "Username sudah digunakan!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, nama_lengkap) VALUES (:username, :password, :nama)");
            $stmt->execute(['username' => $username, 'password' => $hashed_password, 'nama' => $nama_lengkap]);
            
            header("Location: " . appUrl('auth/login.php'));
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Seni Theatrisic</title>
    <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/style.css?v=<?= time() ?>">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f4f7fb; font-family: "Inter", sans-serif; margin: 0; }
        .login-container { background: #fff; padding: 2.5rem 2rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; border: 1px solid #e2e8f0; }
        .login-container h2 { text-align: center; margin-bottom: 2rem; color: #0f172a; font-weight: 800; font-size: 1.4rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; }
        .form-group input { width: 100%; padding: 0.85rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem; background: #f8fafc; font-family: "Inter", sans-serif; }
        .form-group input:focus { outline: none; border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .btn-login { width: 100%; padding: 0.9rem 1.5rem; background-color: #1e293b; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 0.95rem; font-weight: 600; font-family: "Inter", sans-serif; transition: all 0.3s; margin-top: 1rem; }
        .btn-login:hover { background-color: #4f46e5; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(79,70,229,0.3); }
        .register-link { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #64748b; }
        .register-link a { color: #6366f1; text-decoration: none; font-weight: 700; }
        .register-link a:hover { text-decoration: underline; }
        .alert-error { background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.85rem; border-left: 4px solid #ef4444; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>📝 Daftar Akun Baru</h2>
        
        <?php if ($error): ?>
            <div class="alert-error">
                <?= e($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required autofocus>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Daftar Sekarang</button>
        </form>
        <div class="register-link">
            Sudah punya akun? <a href="<?= appUrl('auth/login.php') ?>">Login di sini</a>
        </div>
    </div>
</body>
</html>