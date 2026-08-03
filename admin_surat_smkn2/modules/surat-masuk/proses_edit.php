<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id             = $_POST['id']; // Pastikan di edit.php ada <input type="hidden" name="id">
    $no_surat_asal  = $_POST['no_surat_asal'];
    $pengirim       = $_POST['pengirim'];
    $perihal        = $_POST['perihal'];
    $tgl_terima     = $_POST['tgl_terima'];

    // Ambil nama file lama
    $queryLama = mysqli_query($conn, "SELECT file FROM surat_masuk WHERE id = '$id'");
    $dataLama  = mysqli_fetch_assoc($queryLama);
    $nama_file = $dataLama['file'];

    // Jika ada file baru diupload
    if ($_FILES['file']['name'] != "") {
        if ($dataLama['file'] != "" && file_exists("../../uploads/surat-masuk/" . $dataLama['file'])) {
            unlink("../../uploads/surat-masuk/" . $dataLama['file']);
        }
        $nama_file = "MASUK_" . time() . "_" . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "../../uploads/surat-masuk/" . $nama_file);
    }

    $queryUpdate = "UPDATE surat_masuk SET 
                    no_surat_asal = '$no_surat_asal',
                    pengirim      = '$pengirim',
                    perihal       = '$perihal',
                    tgl_terima    = '$tgl_terima',
                    file          = '$nama_file'
                    WHERE id = '$id'";

    if (mysqli_query($conn, $queryUpdate)) {
        // PERBAIKAN: Harus kembali ke index.php agar tidak memicu alert "Data tidak ditemukan"
        header("Location: index.php?status=update_sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>