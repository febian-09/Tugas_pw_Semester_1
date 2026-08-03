<?php 
include '../../config/koneksi.php'; 
include '../../includes/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Surat Keluar Baru</h5>
            </div>
            <div class="card-body">
                <form action="proses_simpan.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Jenis Surat</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            // Menggunakan $conn sesuai koreksi sebelumnya
                            $tampil = mysqli_query($conn, "SELECT * FROM ref_kategori");
                            while($k = mysqli_fetch_array($tampil)){
                                echo "<option value='$k[id]'>$k[nama] ($k[kode])</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tujuan Surat</label>
                        <input type="text" name="tujuan" class="form-control" placeholder="Contoh: Kepala Dinas Pendidikan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perihal</label>
                        <textarea name="perihal" class="form-control" rows="3" placeholder="Isi perihal surat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kirim</label>
                        <input type="date" name="tgl_kirim" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload File (PDF/JPG)</label>
                        <input type="file" name="file" class="form-control">
                        <div class="form-text text-danger">*Kosongkan jika tidak ada file scan.</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan & Generate Nomor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>