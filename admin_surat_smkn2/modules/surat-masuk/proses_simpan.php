<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_surat_asal = $_POST['no_surat_asal'];
    $pengirim      = $_POST['pengirim'];
    $perihal       = $_POST['perihal'];
    $tgl_terima    = $_POST['tgl_terima'];

    $nama_file = "";
    if ($_FILES['file']['name'] != "") {
        $nama_file = "MASUK_" . time() . "_" . $_FILES['file']['name'];
        // Pastikan folder uploads/surat-masuk/ sudah dibuat!
        move_uploaded_file($_FILES['file']['tmp_name'], "../../uploads/surat-masuk/" . $nama_file);
    }

    $query = "INSERT INTO surat_masuk (no_surat_asal, pengirim, perihal, tgl_terima, file) 
              VALUES ('$no_surat_asal', '$pengirim', '$perihal', '$tgl_terima', '$nama_file')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php?status=sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>