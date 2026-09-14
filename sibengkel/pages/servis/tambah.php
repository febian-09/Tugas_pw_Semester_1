<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$error = '';
$user = getUser();

$mobil_list = $conn->query("
    SELECT m.id, m.no_polisi, m.merek, m.tipe, p.nama as nama_pelanggan, p.id as id_pelanggan
    FROM mobil m
    JOIN pelanggan p ON m.id_pelanggan = p.id
    ORDER BY m.no_polisi
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mobil       = (int)($_POST['id_mobil'] ?? 0);
    $keluhan        = trim($_POST['keluhan'] ?? '');
    $tanggal_masuk  = $_POST['tanggal_masuk'] ?? date('Y-m-d');
    $biaya          = (int)($_POST['biaya'] ?? 0);
    $catatan        = trim($_POST['catatan'] ?? '');

    if (!$id_mobil || empty($keluhan)) {
        $error = 'Mobil dan keluhan wajib diisi.';
    } else {
        // Ambil id_pelanggan dari mobil
        $stmt = $conn->prepare("SELECT id_pelanggan FROM mobil WHERE id = ?");
        $stmt->bind_param("i", $id_mobil);
        $stmt->execute();
        $mobil = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$mobil) {
            $error = 'Data mobil tidak ditemukan.';
        } else {
            $id_pelanggan = $mobil['id_pelanggan'];
            $stmt = $conn->prepare("INSERT INTO servis (id_mobil, id_pelanggan, id_petugas, keluhan, tanggal_masuk, biaya, catatan) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiissis", $id_mobil, $id_pelanggan, $user['id'], $keluhan, $tanggal_masuk, $biaya, $catatan);
            if ($stmt->execute()) {
                header("Location: index.php?msg=added");
                exit;
            } else {
                $error = 'Gagal mencatat servis.';
            }
            $stmt->close();
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-lg"></i> Tambah Servis</h4>
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
                    <label class="form-label">Mobil <span class="text-danger">*</span></label>
                    <select name="id_mobil" class="form-select" required>
                        <option value="">-- Pilih Mobil --</option>
                        <?php while ($m = $mobil_list->fetch_assoc()): ?>
                            <option value="<?= $m['id'] ?>" <?= (isset($_POST['id_mobil']) && $_POST['id_mobil'] == $m['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['no_polisi']) ?> — <?= htmlspecialchars($m['merek'].' '.$m['tipe']) ?> (<?= htmlspecialchars($m['nama_pelanggan']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control" required value="<?= $_POST['tanggal_masuk'] ?? date('Y-m-d') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Keluhan <span class="text-danger">*</span></label>
                    <textarea name="keluhan" class="form-control" rows="3" required placeholder="Contoh: Mesin berbunyi kasar, AC tidak dingin, dll"><?= htmlspecialchars($_POST['keluhan'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estimasi Biaya (Rp)</label>
                    <input type="number" name="biaya" class="form-control" min="0" value="<?= htmlspecialchars($_POST['biaya'] ?? '0') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="catatan" class="form-control" value="<?= htmlspecialchars($_POST['catatan'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Status awal servis akan otomatis <strong>Proses</strong>.
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Servis</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
