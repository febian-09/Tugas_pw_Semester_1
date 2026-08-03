<?php 
include '../../config/koneksi.php'; 
include '../../includes/header.php'; 

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data lama berdasarkan ID (Ganti $koneksi ke $conn)
$query = mysqli_query($conn, "SELECT * FROM surat_keluar WHERE id = '$id'");
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
                <h5 class="mb-0">Edit Surat Keluar</h5>
            </div>
            <div class="card-body">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat (Tidak dapat diubah)</label>
                        <input type="text" class="form-control bg-light" value="<?= $data['no_lengkap']; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Surat</label>
                        <select name="id_kategori" class="form-select" required>
                            <?php
                            // Ganti $koneksi ke $conn
                            $tampil = mysqli_query($conn, "SELECT * FROM ref_kategori");
                            while($k = mysqli_fetch_array($tampil)){
                                $selected = ($k['id'] == $data['id_kategori']) ? "selected" : "";
                                echo "<option value='$k[id]' $selected>$k[nama] ($k[kode])</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tujuan Surat</label>
                        <input type="text" name="tujuan" class="form-control" value="<?= $data['tujuan']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perihal</label>
                        <textarea name="perihal" class="form-control" rows="3" required><?= $data['perihal']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kirim</label>
                        <input type="date" name="tgl_kirim" class="form-control" value="<?= $data['tgl_kirim']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ganti File Arsip (PDF/JPG)</label>
                        <input type="file" name="file" class="form-control">
                        <div class="form-text mt-2 text-muted">
                            File saat ini: 
                            <a href="../../uploads/surat-keluar/<?= $data['file']; ?>" target="_blank"><?= $data['file'] ?: 'Tidak ada file'; ?></a>
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