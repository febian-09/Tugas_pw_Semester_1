<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header("Location: index.php"); exit; }

$stmt = $conn->prepare("SELECT * FROM pelanggan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$pelanggan = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$pelanggan) { header("Location: index.php"); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $no_hp  = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if (empty($nama)) {
        $error = 'Nama wajib diisi.';
    } else {
        $stmt = $conn->prepare("UPDATE pelanggan SET nama=?, email=?, no_hp=?, alamat=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $email, $no_hp, $alamat, $id);
        if ($stmt->execute()) {
            header("Location: index.php?msg=updated");
            exit;
        } else {
            $error = 'Gagal mengubah pelanggan.';
        }
        $stmt->close();
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Pelanggan</h4>
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
                    <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($_POST['nama'] ?? $pelanggan['nama']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? $pelanggan['email']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($_POST['no_hp'] ?? $pelanggan['no_hp']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($_POST['alamat'] ?? $pelanggan['alamat']) ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
