<?php 
include '../../config/koneksi.php'; 
include '../../includes/header.php'; 

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data lama berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM surat_masuk WHERE id = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Surat Masuk</h5>
            </div>
            <div class="card-body">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat Asal</label>
                        <input type="text" name="no_surat_asal" class="form-control" value="<?= $data['no_surat_asal']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Instansi Pengirim</label>
                        <input type="text" name="pengirim" class="form-control" value="<?= $data['pengirim']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perihal</label>
                        <textarea name="perihal" class="form-control" rows="3" required><?= $data['perihal']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Terima</label>
                        <input type="date" name="tgl_terima" class="form-control" value="<?= $data['tgl_terima']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ganti File Scan (PDF/JPG)</label>
                        <input type="file" name="file" class="form-control">
                        <div class="form-text mt-2 text-muted">
                            File saat ini: 
                            <?php if ($data['file'] != ""): ?>
                                <a href="<?= $base_url; ?>uploads/surat-masuk/<?= $data['file']; ?>" target="_blank"><?= $data['file']; ?></a>
                            <?php else: ?>
                                Tidak ada file
                            <?php endif; ?>
                        </div>
                        <div class="form-text text-danger">*Biarkan kosong jika tidak ingin mengganti file.</div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>