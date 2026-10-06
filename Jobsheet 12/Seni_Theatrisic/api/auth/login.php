<?php
// api/auth/login.php

require_once __DIR__ . '/../includes/init.php';
// Baris require_once csrf.php SUDAH DIHAPUS karena fungsinya sudah pindah ke init.php

if (isset($_SESSION['user_id'])) {
    header("Location: " . appUrl('index.php'));
    exit;
}

// Ambil pesan error dari session (jika ada)
$error = $_SESSION['error'] ?? '';
$error_type = $_SESSION['error_type'] ?? 'error';
unset($_SESSION['error'], $_SESSION['error_type']);
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

        #custom-popup-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.6); backdrop-filter: blur(6px); display: flex; align-items: center; justify-content: center; z-index: 99999; animation: fadeIn 0.25s ease-out; }
        #custom-popup-box { background: #fff; padding: 2rem; border-radius: 20px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); animation: scaleUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .popup-icon { width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; }
        .popup-title { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; }
        .popup-message { font-size: 0.95rem; color: #64748b; margin-bottom: 1.75rem; }
        .popup-btn { width: 100%; padding: 0.85rem 1.5rem; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: "Inter", sans-serif; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleUp { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🎭 Login Admin</h2>
        <form method="POST" action="<?= appUrl('auth/proses_login.php') ?>">
            <?= csrf_field() ?>
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
        document.getElementById('custom-popup-overlay').addEventListener('click', function(e) { if (e.target === this) this.remove(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { var p = document.getElementById('custom-popup-overlay'); if (p) p.remove(); } });
    </script>
    <?php endif; ?>
</body>
</html>