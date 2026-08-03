<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file']) && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $nama_file = "SURAT_KELUAR_" . $id . "_" . time() . ".pdf";
    $target_dir = "../../uploads/surat-keluar/";

    // Pindahkan file PDF ke folder uploads
    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_dir . $nama_file)) {
        // Update nama file di database agar tombol 'Lihat File' di index.php bisa diakses
        $query = "UPDATE surat_keluar SET file = '$nama_file' WHERE id = '$id'";
        mysqli_query($conn, $query);
        echo "success";
    } else {
        echo "failed_moving_file";
    }
}
?>