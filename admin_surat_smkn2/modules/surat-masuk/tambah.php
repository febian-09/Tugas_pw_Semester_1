<?php 
include '../../config/koneksi.php'; 
include '../../includes/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Tambah Surat Masuk</h5>
            </div>
            <div class="card-body">
                <form action="proses_simpan.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nomor Surat Asal</label>
                        <input type="text" name="no_surat_asal" class="form-control" placeholder="Contoh: 421/123/DISDIK-2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instansi Pengirim</label>
                        <input type="text" name="pengirim" class="form-control" placeholder="Contoh: Dinas Pendidikan Kota Padang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perihal</label>
                        <textarea name="perihal" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Terima</label>
                        <input type="date" name="tgl_terima" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Scan Surat (PDF/JPG)</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>