<?php 
include '../../config/koneksi.php'; 
include '../../includes/header.php'; 

// Opsional: Cek jika yang akses bukan admin, bisa ditendang (jika ada sistem role)
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Tambah Pengguna Baru</h5>
            </div>
            <div class="card-body">
                <form action="proses_tambah.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: admin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role / Jabatan</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Administrator</option>
                            <option value="petugas">Petugas TU</option>
                        </select>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="../../index.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-dark">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>