<?php 
session_start();
if($_SESSION['status'] != "login"){
    header("location:" . $base_url . "login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Arsip SMKN 2 Padang</title>
    <link rel="stylesheet" href="<?= $base_url; ?>assets/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { margin-bottom: 20px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="<?= $base_url; ?>index.php">E-Arsip SMKN 2</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= $base_url; ?>index.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $base_url; ?>modules/surat-keluar/index.php">Surat Keluar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $base_url; ?>modules/surat-masuk/index.php">Surat Masuk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $base_url; ?>modules/user/index.php">Manajemen User</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            Halo, <?= $_SESSION['nama']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item text-danger" href="<?= $base_url; ?>logout.php" onclick="return confirm('Yakin ingin keluar?')">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">