<?php 
session_start();
include 'config/koneksi.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$data = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) > 0) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['id_user'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        
        // TAMBAHKAN BARIS INI:
        $_SESSION['role'] = $data['role']; 
        
        $_SESSION['status'] = "login";
        
        header("location:index.php");
    } else {
        header("location:login.php?pesan=gagal");
    }
} else {
    header("location:login.php?pesan=gagal");
}
?>