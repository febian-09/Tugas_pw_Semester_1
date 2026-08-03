<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role         = $_POST['role'];
    
    // Keamanan: Enkripsi password sebelum masuk ke database
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Query simpan ke tabel users
    $query = "INSERT INTO users (username, password, nama_lengkap, role) 
              VALUES ('$username', '$password', '$nama_lengkap', '$role')";

    if (mysqli_query($conn, $query)) {
        // Jika sukses, kembali ke dashboard atau list user (jika ada)
        header("Location: ../../index.php?status=user_ditambah");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>