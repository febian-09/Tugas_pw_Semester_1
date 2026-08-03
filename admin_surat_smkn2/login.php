<?php
include 'config/koneksi.php';
session_start();

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Arsip SMKN 2 Padang</title>
    <link rel="stylesheet" href="<?= $base_url; ?>assets/css/bootstrap.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .login-container { margin-top: 100px; max-width: 400px; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-container w-100">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Login E-Arsip</h3>
                
                <?php 
                if(isset($_GET['pesan'])){
                    if($_GET['pesan'] == "gagal"){
                        echo "<div class='alert alert-danger small'>Username atau Password salah!</div>";
                    } else if($_GET['pesan'] == "logout"){
                        echo "<div class='alert alert-success small'>Anda telah berhasil logout.</div>";
                    } else if($_GET['pesan'] == "belum_login"){
                        echo "<div class='alert alert-warning small'>Anda harus login untuk mengakses halaman tersebut.</div>";
                    }
                }
                ?>

                <form action="auth.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
                </form>
            </div>
        </div>
        <p class="text-center mt-3 text-muted small">&copy; 2026 SMKN 2 Padang - Kelompok 3</p>
    </div>
</div>

</body>
</html>