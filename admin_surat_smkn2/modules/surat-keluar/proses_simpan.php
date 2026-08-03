<?php
include '../../config/koneksi.php';
include '../../config/helper.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_kategori    = $_POST['id_kategori'];
    $tujuan         = $_POST['tujuan'];
    $perihal        = $_POST['perihal'];
    $tgl_kirim      = $_POST['tgl_kirim'];

    // Mengambil fungsi penomoran dari helper
    $penomoran  = generateNoSurat($conn, $id_kategori);
    $no_urut    = $penomoran['no_urut'];
    $no_lengkap = $penomoran['no_lengkap'];

    // Proses upload file manual (jika ada)
    $nama_file = "";
    if($_FILES['file']['name'] != ""){
        $nama_file = time()."_".$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "../../uploads/surat-keluar/".$nama_file);
    }

    // Query Simpan Data
    $query = "INSERT INTO surat_keluar (no_urut, no_lengkap, id_kategori, tujuan, perihal, tgl_kirim, file)
              VALUES ('$no_urut','$no_lengkap','$id_kategori','$tujuan','$perihal','$tgl_kirim','$nama_file')";

    if(mysqli_query($conn, $query)){
        $id_baru = mysqli_insert_id($conn);
        
        // JIKA TIDAK ADA FILE MANUAL, GENERATE PDF OTOMATIS
        if($nama_file == ""){
            header("Location: cetak.php?id=" . $id_baru . "&autosave=true");
        } else {
            header("Location: index.php?status=sukses");
        }
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>