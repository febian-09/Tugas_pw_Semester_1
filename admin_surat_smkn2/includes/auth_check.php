<?php
session_start();
// Jika tidak ada session username, artinya belum login
if (!isset($_SESSION['username'])) {
    header("Location: " . $base_url . "login.php?pesan=belum_login");
    exit();
}
?>