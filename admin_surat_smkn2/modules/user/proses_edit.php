<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id           = $_POST['id'];
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role         = $_POST['role'];

    // Cek apakah password diisi
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET username='$username', nama_lengkap='$nama_lengkap', password='$password', role='$role' WHERE id='$id'";
    } else {
        // Jika password kosong, jangan update kolom password
        $query = "UPDATE users SET username='$username', nama_lengkap='$nama_lengkap', role='$role' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: index.php?status=update_sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>