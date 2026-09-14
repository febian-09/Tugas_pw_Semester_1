<?php
require_once __DIR__ . '/auth.php';
cekLogin();
$user = getUser();
$base = getBasePath();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBENGKEL - Sistem Informasi Servis Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f1f5f9; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            border-radius: 8px;
            margin-bottom: 4px;
            padding: 10px 16px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.12);
            color: #fff;
        }
        .sidebar .nav-link i { width: 24px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-4px); }
        .table th { font-weight: 600; background-color: #f8fafc; }
        .badge-proses { background-color: #f59e0b; }
        .badge-selesai { background-color: #10b981; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <div class="text-center mb-4 mt-2">
                <h5 class="text-white fw-bold mb-0"><i class="bi bi-tools"></i> SIBENGKEL</h5>
                <small class="text-white-50">Sistem Informasi Servis Mobil</small>
            </div>
            <hr class="text-white-50">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'dashboard') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'mobil') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/mobil/index.php">
                        <i class="bi bi-car-front"></i> Data Mobil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'pelanggan') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/pelanggan/index.php">
                        <i class="bi bi-people"></i> Data Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'servis') !== false ? 'active' : '' ?>" href="<?= $base ?>/pages/servis/index.php">
                        <i class="bi bi-wrench-adjustable"></i> Servis
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
        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
