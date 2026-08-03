<?php
// fungsi untuk mengubah angka biasan jadi romawi
function getRomawi($bulan){
    $romawi =[
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
        7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    ];
    return $romawi[(int)$bulan];
}

// fungsi membuat nomor surat lengkap
function generateNoSurat($conn) {
    // ambil kode dari ref_kategori
    $queryKategori = mysqli_query($conn, "SELECT kode from ref_kategori where id = '$id_kategori'");
    $dataKategori = mysqli_fetch_assoc($queryKategori);
    $kode = $dataKategori['kode'];
    
    // ambil waktu dan ubah ke romawi
    $tahun = date('Y');
    $bulan = date('m');
    $romawi = getRomawi($bulan);

    // cari no urut terakhir
    $queryCek = mysqli_query($conn, "SELECT max(no_urut) as terakhir from surat_keluar where year(tgl_kirim) = '$tahun'");
    $dataCek = mysqli_fetch_assoc($queryCek);
    $no_urut = ($dataCek['terakhir'] ?? 0) + 1;

    // format nomor urut
    $no_urut_format = str_pad($no_urut, 3, "0", STR_PAD_LEFT);
    
    // rangkai no lengkap
    $no_lengkap = "$no_urut_format/$kode/SMKN2-PDG/$romawi/$tahun";

    return [
        'no_urut'       => $no_urut,
        'no_lengkap'    => $no_lengkap
    ];
}

?>