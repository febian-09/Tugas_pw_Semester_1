<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

$queryFile = mysqli_query($conn, "SELECT file FROM surat_masuk WHERE id = '$id'");
$dataFile = mysqli_fetch_assoc($queryFile);

if ($dataFile['file'] != "") {
    $path = "../../uploads/surat-masuk/" . $dataFile['file'];
    if (file_exists($path)) { unlink($path); }
}

$delete = mysqli_query($conn, "DELETE FROM surat_masuk WHERE id = '$id'");

if ($delete) {
    header("Location: index.php?status=hapus");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>