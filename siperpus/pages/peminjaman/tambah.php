<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$error = '';
$user = getUser();

// Ambil data anggota & buku yang stok > 0
$anggota_list = $conn->query("SELECT id, nama FROM anggota ORDER BY nama");
$buku_list = $conn->query("SELECT id, judul, stok FROM buku WHERE stok > 0 ORDER BY judul");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_anggota      = (int)($_POST['id_anggota'] ?? 0);
    $id_buku         = (int)($_POST['id_buku'] ?? 0);
    $tanggal_pinjam  = $_POST['tanggal_pinjam'] ?? date('Y-m-d');
    $tanggal_kembali = $_POST['tanggal_kembali'] ?? '';

    if (!$id_anggota || !$id_buku || !$tanggal_kembali) {
        $error = 'Semua field wajib diisi.';
    } elseif ($tanggal_kembali < $tanggal_pinjam) {
        $error = 'Tanggal kembali tidak boleh lebih awal dari tanggal pinjam.';
    } else {
        // Cek stok
        $stmt = $conn->prepare("SELECT stok FROM buku WHERE id = ?");
        $stmt->bind_param("i", $id_buku);
        $stmt->execute();
        $buku = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$buku || $buku['stok'] < 1) {
            $error = 'Stok buku tidak tersedia.';
        } else {
            // Mulai transaksi
            $conn->begin_transaction();
            try {
                // Insert peminjaman
                $stmt = $conn->prepare("INSERT INTO peminjaman (id_anggota, id_buku, id_petugas, tanggal_pinjam, tanggal_kembali) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("iiiss", $id_anggota, $id_buku, $user['id'], $tanggal_pinjam, $tanggal_kembali);
                $stmt->execute();
                $stmt->close();

                // Kurangi stok
                $stmt = $conn->prepare("UPDATE buku SET stok = stok - 1 WHERE id = ?");
                $stmt->bind_param("i", $id_buku);
                $stmt->execute();
                $stmt->close();

                $conn->commit();
                header("Location: index.php?msg=added");
                exit;
            } catch (Exception $e) {
                $conn->rollback();
                $error = 'Gagal mencatat peminjaman: ' . $e->getMessage();
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-lg"></i> Pinjam Buku</h4>
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
                    <label class="form-label">Anggota <span class="text-danger">*</span></label>
                    <select name="id_anggota" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        <?php while ($a = $anggota_list->fetch_assoc()): ?>
                            <option value="<?= $a['id'] ?>" <?= (isset($_POST['id_anggota']) && $_POST['id_anggota'] == $a['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($a['nama']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Buku <span class="text-danger">*</span></label>
                    <select name="id_buku" class="form-select" required>
                        <option value="">-- Pilih Buku (stok tersedia) --</option>
                        <?php while ($b = $buku_list->fetch_assoc()): ?>
                            <option value="<?= $b['id'] ?>" <?= (isset($_POST['id_buku']) && $_POST['id_buku'] == $b['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['judul']) ?> (Stok: <?= $b['stok'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pinjam" class="form-control" required value="<?= $_POST['tanggal_pinjam'] ?? date('Y-m-d') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Kembali (Rencana) <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_kembali" class="form-control" required value="<?= $_POST['tanggal_kembali'] ?? date('Y-m-d', strtotime('+7 days')) ?>">
                </div>
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Stok buku akan otomatis berkurang setelah peminjaman dicatat.
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Peminjaman</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
