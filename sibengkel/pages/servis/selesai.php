<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT s.*, p.nama as nama_pelanggan, m.no_polisi, m.merek, m.tipe
    FROM servis s
    JOIN pelanggan p ON s.id_pelanggan = p.id
    JOIN mobil m ON s.id_mobil = m.id
    WHERE s.id = ? AND s.status = 'proses'
");
$stmt->bind_param("i", $id);
$stmt->execute();
$servis = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$servis) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $biaya = (int)($_POST['biaya'] ?? 0);
    $catatan = trim($_POST['catatan'] ?? '');
    $tanggal_selesai = date('Y-m-d');

    $stmt = $conn->prepare("UPDATE servis SET status = 'selesai', tanggal_selesai = ?, biaya = ?, catatan = ? WHERE id = ?");
    $stmt->bind_param("sisi", $tanggal_selesai, $biaya, $catatan, $id);
    if ($stmt->execute()) {
        header("Location: index.php?msg=finished");
        exit;
    } else {
        $error = 'Gagal menyelesaikan servis.';
    }
    $stmt->close();
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-check2-circle"></i> Selesaikan Servis</h4>
    <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-6">
                <p class="mb-1 text-muted">Pelanggan</p>
                <h5><?= htmlspecialchars($servis['nama_pelanggan']) ?></h5>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted">Mobil</p>
                <h5><?= htmlspecialchars($servis['no_polisi']) ?> — <?= htmlspecialchars($servis['merek'].' '.$servis['tipe']) ?></h5>
            </div>
            <div class="col-12 mt-2">
                <p class="mb-1 text-muted">Keluhan</p>
                <p><?= nl2br(htmlspecialchars($servis['keluhan'])) ?></p>
            </div>
        </div>

        <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Biaya Final (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="biaya" class="form-control" min="0" required value="<?= htmlspecialchars($servis['biaya']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Catatan Tambahan</label>
                    <input type="text" name="catatan" class="form-control" value="<?= htmlspecialchars($servis['catatan'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success"><i class="bi bi-check2-circle"></i> Tandai Selesai</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
