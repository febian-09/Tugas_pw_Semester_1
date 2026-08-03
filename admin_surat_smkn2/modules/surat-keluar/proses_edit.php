<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id          = $_POST['id'];
    $id_kategori = $_POST['id_kategori'];
    $tujuan      = $_POST['tujuan'];
    $perihal     = $_POST['perihal'];
    $tgl_kirim   = $_POST['tgl_kirim'];

    // 1. Ambil data lama untuk mengecek file lama (Ganti $koneksi ke $conn)
    $queryLama = mysqli_query($conn, "SELECT file FROM surat_keluar WHERE id = '$id'");
    $dataLama  = mysqli_fetch_assoc($queryLama);
    $nama_file = $dataLama['file'];

    // 2. Jika user mengunggah file baru
    if ($_FILES['file']['name'] != "") {
        // Hapus file lama jika ada
        if ($dataLama['file'] != "" && file_exists("../../uploads/surat-keluar/" . $dataLama['file'])) {
            unlink("../../uploads/surat-keluar/" . $dataLama['file']);
        }

        // Upload file baru
        $nama_file = time() . "_" . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "../../uploads/surat-keluar/" . $nama_file);
    }

    // 3. Update data di database (Ganti $koneksi ke $conn)
    $queryUpdate = "UPDATE surat_keluar SET 
                    id_kategori = '$id_kategori',
                    tujuan      = '$tujuan',
                    perihal     = '$perihal',
                    tgl_kirim   = '$tgl_kirim',
                    file        = '$nama_file'
                    WHERE id = '$id'";

    if (mysqli_query($conn, $queryUpdate)) {
        header("Location: index.php?status=update_sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>