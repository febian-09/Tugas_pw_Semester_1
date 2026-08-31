<?php
session_start();
require_once 'config/database.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, nama, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['role']     = $user['role'];
                header("Location: pages/dashboard.php");
                exit;
            } else {
                $error = 'Password salah.';
            }
        } else {
            $error = 'Username tidak ditemukan.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPERPUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #1e3a5f, #2a5298);
            border-radius: 16px 16px 0 0;
            padding: 30px;
            text-align: center;
            color: white;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="login-header">
            <i class="bi bi-book fs-1"></i>
            <h4 class="mt-2 mb-0">SIPERPUS</h4>
            <small>Sistem Informasi Perpustakaan</small>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>

            <div class="mt-4 p-3 bg-light rounded">
                <small class="text-muted d-block mb-1"><strong>Akun Demo:</strong></small>
                <small class="text-muted">Admin → username: <code>admin</code> / password: <code>admin123</code></small><br>
                <small class="text-muted">Petugas → username: <code>petugas</code> / password: <code>petugas123</code></small>
            </div>
        </div>
    </div>
</body>
</html>
