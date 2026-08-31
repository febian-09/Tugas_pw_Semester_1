<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Deteksi base path
function getBasePath() {
    $script_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $base = preg_replace('#/pages(/.*)?$#', '', $script_path);
    if ($base === '/' || $base === '') {
        $base = '';
    }
    return $base;
}

// Cek apakah user sudah login
function cekLogin() {
    if (!isset($_SESSION['user_id'])) {
        $base = getBasePath();
        header("Location: " . $base . "/login.php");
        exit;
    }
}

// Cek role admin
function cekAdmin() {
    cekLogin();
    if ($_SESSION['role'] !== 'admin') {
        $base = getBasePath();
        header("Location: " . $base . "/pages/dashboard.php");
        exit;
    }
}

// Ambil data user yang login
function getUser() {
    return [
        'id'       => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'nama'     => $_SESSION['nama'] ?? null,
        'role'     => $_SESSION['role'] ?? null
    ];
}
?>
