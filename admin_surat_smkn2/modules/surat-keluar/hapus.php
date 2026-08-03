<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

// 1. Ambil nama file sebelum datanya dihapus (Ganti $koneksi ke $conn)
$queryFile = mysqli_query($conn, "SELECT file FROM surat_keluar WHERE id = '$id'");
$dataFile = mysqli_fetch_assoc($queryFile);

// 2. Hapus file fisik jika ada
if ($dataFile['file'] != "") {
    if(file_exists("../../uploads/surat-keluar/" . $dataFile['file'])) {
        unlink("../../uploads/surat-keluar/" . $dataFile['file']);
    }
}

// 3. Hapus data dari database (Ganti $koneksi ke $conn)
$delete = mysqli_query($conn, "DELETE FROM surat_keluar WHERE id = '$id'");

if ($delete) {
    header("Location: index.php?status=hapus_sukses");
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
?>