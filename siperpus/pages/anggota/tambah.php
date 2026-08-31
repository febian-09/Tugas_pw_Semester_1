<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $no_hp  = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if (empty($nama)) {
        $error = 'Nama wajib diisi.';
    } else {
        $stmt = $conn->prepare("INSERT INTO anggota (nama, email, no_hp, alamat) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $email, $no_hp, $alamat);
        if ($stmt->execute()) {
            header("Location: index.php?msg=added");
            exit;
        } else {
            $error = 'Gagal menambahkan anggota.';
        }
        $stmt->close();
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-lg"></i> Tambah Anggota</h4>
    <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
