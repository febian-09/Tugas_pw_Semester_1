<?php
include '../../config/koneksi.php';
session_start();

$id = $_GET['id'];

// Mencegah hapus diri sendiri dari URL langsung
if ($id == $_SESSION['id_user']) {
    echo "<script>alert('Anda tidak bisa menghapus akun Anda sendiri!'); window.location='index.php';</script>";
    exit();
}

$delete = mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");

if ($delete) {
    header("Location: index.php?status=hapus_sukses");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>