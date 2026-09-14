<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$error = '';
$pelanggan_list = $conn->query("SELECT id, nama FROM pelanggan ORDER BY nama");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = (int)($_POST['id_pelanggan'] ?? 0);
    $no_polisi    = strtoupper(trim($_POST['no_polisi'] ?? ''));
    $merek        = trim($_POST['merek'] ?? '');
    $tipe         = trim($_POST['tipe'] ?? '');
    $tahun        = (int)($_POST['tahun'] ?? 0);
    $warna        = trim($_POST['warna'] ?? '');

    if (!$id_pelanggan || empty($no_polisi) || empty($merek) || empty($tipe)) {
        $error = 'Pemilik, No. Polisi, Merek, dan Tipe wajib diisi.';
    } else {
        $stmt = $conn->prepare("INSERT INTO mobil (id_pelanggan, no_polisi, merek, tipe, tahun, warna) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $id_pelanggan, $no_polisi, $merek, $tipe, $tahun, $warna);
        if ($stmt->execute()) {
            header("Location: index.php?msg=added");
            exit;
        } else {
            $error = 'Gagal menambahkan mobil. No. Polisi mungkin sudah terdaftar.';
        }
        $stmt->close();
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-lg"></i> Tambah Mobil</h4>
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
                    <label class="form-label">Pemilik (Pelanggan) <span class="text-danger">*</span></label>
                    <select name="id_pelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php while ($p = $pelanggan_list->fetch_assoc()): ?>
                            <option value="<?= $p['id'] ?>" <?= (isset($_POST['id_pelanggan']) && $_POST['id_pelanggan'] == $p['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['nama']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Polisi <span class="text-danger">*</span></label>
                    <input type="text" name="no_polisi" class="form-control" required placeholder="Contoh: B 1234 ABC"
                           value="<?= htmlspecialchars($_POST['no_polisi'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Merek <span class="text-danger">*</span></label>
                    <input type="text" name="merek" class="form-control" required placeholder="Toyota, Honda, dll"
                           value="<?= htmlspecialchars($_POST['merek'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <input type="text" name="tipe" class="form-control" required placeholder="Avanza, Civic, dll"
                           value="<?= htmlspecialchars($_POST['tipe'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" min="1980" max="2099"
                           value="<?= htmlspecialchars($_POST['tahun'] ?? date('Y')) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Warna</label>
                    <input type="text" name="warna" class="form-control" value="<?= htmlspecialchars($_POST['warna'] ?? '') ?>">
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
