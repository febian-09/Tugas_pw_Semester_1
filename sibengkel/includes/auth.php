<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getBasePath() {
    $script_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $base = preg_replace('#/pages(/.*)?$#', '', $script_path);
    if ($base === '/' || $base === '') {
        $base = '';
    }
    return $base;
}

function cekLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . getBasePath() . "/login.php");
        exit;
    }
}

function cekAdmin() {
    cekLogin();
    if ($_SESSION['role'] !== 'admin') {
        header("Location: " . getBasePath() . "/pages/dashboard.php");
        exit;
    }
}

function getUser() {
    return [
        'id'       => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'nama'     => $_SESSION['nama'] ?? null,
        'role'     => $_SESSION['role'] ?? null
    ];
}
?>
