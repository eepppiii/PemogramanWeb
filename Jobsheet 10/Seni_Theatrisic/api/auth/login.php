<?php
// api/auth/login.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/init.php';

if (isset($_SESSION['user_id'])) {
    header("Location: " . appUrl('index.php'));
    exit;
}

$error = '';
$error_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username dan Password wajib diisi!";
        $error_type = "warning";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role'] = $user['role'];

            header("Location: " . appUrl('index.php'));
            exit;
        } else {
            $error = "Username atau Password yang Anda masukkan salah!";
            $error_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Seni Theatrisic</title>
    <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/style.css?v=<?= time() ?>">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f4f7fb; font-family: "Inter", sans-serif; margin: 0; }
        .login-container { background: #ffffff; padding: 2.5rem 2rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); width: 100%; max-width: 400px; border: 1px solid #e2e8f0; }
        .login-container h2 { text-align: center; margin-bottom: 2rem; color: #0f172a; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width: 100%; padding: 0.85rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem; background: #f8fafc; transition: all 0.2s ease; font-family: "Inter", sans-serif; }
        .form-group input:focus { outline: none; border-color: #6366f1; background: #ffffff; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }
        .btn-login { width: 100%; padding: 0.9rem 1.5rem; background-color: #1e293b; color: #ffffff; border: none; border-radius: 8px; cursor: pointer; font-size: 0.95rem; font-weight: 600; font-family: "Inter", sans-serif; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 1rem; }
        .btn-login:hover { background-color: #4f46e5; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3); }
        .btn-login:active { transform: translateY(0); }
        .register-link { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #64748b; }
        .register-link a { color: #6366f1; text-decoration: none; font-weight: 700; transition: color 0.2s; }
        .register-link a:hover { color: #4f46e5; text-decoration: underline; }

        /* ============ CSS POPUP (SELF-CONTAINED) ============ */
        #custom-popup-overlay {
            position: fixed; inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            z-index: 99999;
            animation: popupFadeIn 0.25s ease-out;
        }
        #custom-popup-box {
            background: #fff; padding: 2rem; border-radius: 20px;
            max-width: 400px; width: 90%; text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            animation: popupScaleUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .popup-icon {
            width: 80px; height: 80px; margin: 0 auto 1rem;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 2.5rem;
        }
        .popup-title { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; }
        .popup-message { font-size: 0.95rem; color: #64748b; margin-bottom: 1.75rem; line-height: 1.5; }
        .popup-btn {
            width: 100%; padding: 0.85rem 1.5rem;
            color: #fff; border: none; border-radius: 10px;
            font-weight: 700; font-size: 0.95rem; cursor: pointer;
            transition: all 0.2s ease; font-family: "Inter", sans-serif;
        }
        .popup-btn:hover { transform: translateY(-2px); }
        @keyframes popupFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes popupScaleUp { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-login">Masuk ke Sistem</button>
        </form>
        <div class="register-link">
            Belum punya akun? <a href="<?= appUrl('auth/register.php') ?>">Daftar di sini</a>
        </div>
    </div>

    <?php if ($error): ?>
    <!-- ============ POPUP LANGSUNG DI HTML (TIDAK BERGANTUNG PADA FILE JS EKSTERNAL) ============ -->
    <div id="custom-popup-overlay">
        <div id="custom-popup-box" style="border-top: 6px solid <?= $error_type === 'warning' ? '#f59e0b' : '#ef4444' ?>;">
            <div class="popup-icon" style="background: <?= $error_type === 'warning' ? '#fef3c7' : '#fee2e2' ?>;">
                <?= $error_type === 'warning' ? '⚠️' : '❌' ?>
            </div>
            <h3 class="popup-title"><?= $error_type === 'warning' ? 'Peringatan' : 'Login Gagal' ?></h3>
            <p class="popup-message"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
            <button type="button" class="popup-btn" 
                style="background: linear-gradient(135deg, <?= $error_type === 'warning' ? '#f59e0b, #d97706' : '#ef4444, #b91c1c' ?>);"
                onclick="document.getElementById('custom-popup-overlay').remove()">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        // Klik di luar box untuk menutup
        document.getElementById('custom-popup-overlay').addEventListener('click', function(e) {
            if (e.target === this) this.remove();
        });
        // Tekan ESC untuk menutup
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var p = document.getElementById('custom-popup-overlay');
                if (p) p.remove();
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>