<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = trim($_POST['judul'] ?? '');
    $penulis  = trim($_POST['penulis'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $tahun    = (int)($_POST['tahun'] ?? 0);
    $stok     = (int)($_POST['stok'] ?? 0);

    if (empty($judul) || empty($penulis)) {
        $error = 'Judul dan Penulis wajib diisi.';
    } elseif ($stok < 0) {
        $error = 'Stok tidak boleh negatif.';
    } else {
        $stmt = $conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun, stok) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $judul, $penulis, $penerbit, $tahun, $stok);
        if ($stmt->execute()) {
            header("Location: index.php?msg=added");
            exit;
        } else {
            $error = 'Gagal menambahkan buku.';
        }
        $stmt->close();
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-lg"></i> Tambah Buku</h4>
    <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" required value="<?= htmlspecialchars($_POST['judul'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control" min="0" required value="<?= htmlspecialchars($_POST['stok'] ?? '1') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penulis <span class="text-danger">*</span></label>
                    <input type="text" name="penulis" class="form-control" required value="<?= htmlspecialchars($_POST['penulis'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="<?= htmlspecialchars($_POST['penerbit'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" min="1900" max="2099" value="<?= htmlspecialchars($_POST['tahun'] ?? date('Y')) ?>">
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
