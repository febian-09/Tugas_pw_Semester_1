<?php
require_once __DIR__ . '/auth.php';
cekLogin();
$user = getUser();

// Deteksi base path otomatis agar link tetap benar di XAMPP / Laragon
$script_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base = preg_replace('#/pages(/.*)?$#', '', $script_path);
if ($base === '/' || $base === '') {
    $base = '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPERPUS - Sistem Informasi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f2744 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            margin-bottom: 4px;
            padding: 10px 16px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.15);
            color: #fff;
        }
        .sidebar .nav-link i { width: 24px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-4px); }
        .table th { font-weight: 600; background-color: #f8f9fa; }
        .badge-status-dipinjam { background-color: #fd7e14; }
        .badge-status-dikembalikan { background-color: #198754; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <div class="text-center mb-4 mt-2">
                <h5 class="text-white fw-bold mb-0"><i class="bi bi-book"></i> SIPERPUS</h5>
                <small class="text-white-50">Sistem Informasi Perpustakaan</small>
            </div>
            <hr class="text-white-50">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'dashboard') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'buku') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/buku/index.php">
                        <i class="bi bi-book-half"></i> Data Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'anggota') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/anggota/index.php">
                        <i class="bi bi-people"></i> Data Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'peminjaman') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/peminjaman/index.php">
                        <i class="bi bi-arrow-left-right"></i> Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'laporan') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/laporan/index.php">
                        <i class="bi bi-file-earmark-text"></i> Laporan
                    </a>
                </li>
                <hr class="text-white-50">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= $base ?>/logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
            <div class="mt-auto pt-4 text-center">
                <small class="text-white-50">Login sebagai</small><br>
                <span class="text-white fw-semibold"><?= htmlspecialchars($user['nama']) ?></span><br>
                <span class="badge bg-light text-dark mt-1"><?= strtoupper($user['role']) ?></span>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
