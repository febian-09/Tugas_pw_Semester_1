<?php 
include '../../config/koneksi.php'; 
include '../../includes/header.php'; 

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
$data  = mysqli_fetch_assoc($query);
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Edit Pengguna</h5>
            </div>
            <div class="card-body">
                <form action="proses_edit.php" method="POST">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $data['username']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $data['nama_lengkap']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : ''; ?>>Administrator</option>
                            <option value="petugas" <?= $data['role'] == 'petugas' ? 'selected' : ''; ?>>Petugas TU</option>
                        </select>
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