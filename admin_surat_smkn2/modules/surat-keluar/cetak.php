<?php
include '../../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$autosave = isset($_GET['autosave']) ? true : false;

$sql = "SELECT sk.*, rk.nama as nama_kategori FROM surat_keluar sk 
        JOIN ref_kategori rk ON sk.id_kategori = rk.id WHERE sk.id = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) < 1) {
    echo "<script>alert('Data tidak ditemukan!'); window.close();</script>";
    exit();
}

$data = mysqli_fetch_assoc($result);

function tgl_indonesia($tanggal) {
    $bulan = array (1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $split = explode('-', date('Y-m-d', strtotime($tanggal)));
    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - <?= $data['no_lengkap']; ?></title>
    <style>
        body { font-family: "Times New Roman", Times, serif; background-color: #fff; color: #000; margin: 0; padding: 30px; }
        .line-pembatas { border-bottom: 5px double #000; margin-top: 10px; margin-bottom: 20px; }
        .tabel-header { width: 100%; border-collapse: collapse; }
        .tabel-header td { text-align: center; font-size: 14px; }
        .text-instansi { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .text-alamat { font-size: 12px; font-style: italic; }
        .info-surat { width: 100%; margin-top: 20px; font-size: 16px; }
        .info-surat td { vertical-align: top; }
        .isi-surat { margin-top: 30px; font-size: 16px; line-height: 1.6; text-align: justify; }
        .tanda-tangan-container { margin-top: 50px; float: right; text-align: left; width: 300px; font-size: 16px; }
        @media print { body { padding: 0; } .no-print { display: none; } }
    </style>
</head>
<body>

<?php if (!$autosave): ?>
<div class="no-print" style="background: #f1f1f1; padding: 10px; text-align: center; margin-bottom: 20px;">
    <button onclick="window.print();" style="padding: 8px 15px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px;">Konfirmasi Simpan ke PDF</button>
    <a href="index.php" style="padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; margin-left: 10px; font-size: 14px;">Kembali</a>
</div>
<?php else: ?>
<div id="loading-overlay" style="position: fixed; top:0; left:0; width:100%; height:100%; background:white; z-index:9999; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:Arial,sans-serif;">
    <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #0d6efd; border-radius: 50%; animation: spin 1s linear infinite;"></div>
    <p style="margin-top: 20px; font-size: 16px; color: #555;">Mengarsipkan Dokumen ke Sistem E-Arsip...</p>
</div>
<style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
<?php endif; ?>

<div id="konten-surat" style="background: #fff; padding: 10px;">
    <table class="tabel-header">
        <tr>
            <td style="width: 15%; text-align: left;">
                <img src="../../assets/img/logo.ico" alt="Logo Instansi" style="width: 80px; height: auto;">
            </td>
            <td style="width: 85%;">
                <div style="font-size: 15px; font-weight: bold;">PEMERINTAH PROVINSI SUMATERA BARAT</div>
                <div style="font-size: 14px; font-weight: bold;">DINAS PENDIDIKAN</div>
                <div class="text-instansi">SMK NEGERI 2 PADANG</div>
                <div class="text-alamat">Jl. Jenderal Ahmad Yani No. 5, Kota Padang, Sumatera Barat</div>
                <div style="font-size: 11px;">Telp: (0751) 22003 | Email: info@smkn2padang.sch.id</div>
            </td>
        </tr>
    </table>

    <div class="line-pembatas"></div>

    <table class="info-surat">
        <tr>
            <td style="width: 15%;">Nomor</td>
            <td style="width: 2%;">:</td>
            <td style="width: 48%;"><strong><?= $data['no_lengkap']; ?></strong></td>
            <td style="width: 35%; text-align: right;">Padang, <?= tgl_indonesia($data['tgl_kirim']); ?></td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>Penting / Biasa</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td><u><?= $data['perihal']; ?></u></td>
        </tr>
    </table>

    <br>
    <div style="font-size: 16px;">
        Kepada Yth.<br>
        <strong><?= $data['tujuan']; ?></strong><br>
        di Tempat
    </div>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>Sehubungan dengan pelaksanaan kegiatan administrasi sekolah dan berdasarkan kebutuhan penataan dokumentasi instansi, dengan ini kami sampaikan mengenai perihal <strong><?= $data['perihal']; ?></strong> yang ditujukan demi kelancaran agenda kerja di lingkungan SMK Negeri 2 Padang.</p>
        <p>Diharapkan pihak penerima dapat menindaklanjuti isi dari maksud surat ini sebagaimana mestinya. Atas perhatian, kerja sama, dan koordinasi yang baik dari Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>

    <div class="tanda-tangan-container">
        <div style="margin-bottom: 5px;">Padang, <?= tgl_indonesia($data['tgl_kirim']); ?></div>
        <div>Kepala Urusan Tata Usaha</div>
        <div>SMK Negeri 2 Padang,</div>
        <br><br><br><br>
        <div><strong><u>Aria Amelia, S.Pd.</u></strong></div>
        <div>NIP. 19850406 201001 2 003</div>
    </div>
    <div style="clear: both;"></div>
</div>

<?php if ($autosave): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const element = document.getElementById('konten-surat');
    const opt = {
        margin:       15,
        filename:     'surat_keluar.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).outputPdf('blob').then(function(pdfBlob) {
        const formData = new FormData();
        formData.append('pdf_file', pdfBlob, 'surat.pdf');
        formData.append('id', '<?= $id; ?>');

        fetch('upload_generated_pdf.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(result => {
            if(result.trim() === 'success') {
                window.location.href = 'index.php?status=sukses';
            } else {
                alert('Gagal mengarsipkan otomatis: ' + result);
                window.location.href = 'index.php';
            }
        });
    });
});
</script>
<?php else: ?>
<script>window.onload = function() { window.print(); }</script>
<?php endif; ?>

</body>
</html>