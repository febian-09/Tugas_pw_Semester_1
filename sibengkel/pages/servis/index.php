<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$status_filter = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

$sql = "SELECT s.*, p.nama as nama_pelanggan, m.no_polisi, m.merek, m.tipe, u.nama as nama_petugas
        FROM servis s
        JOIN pelanggan p ON s.id_pelanggan = p.id
        JOIN mobil m ON s.id_mobil = m.id
        JOIN users u ON s.id_petugas = u.id
        WHERE 1=1";

$params = [];
$types = '';

if ($status_filter && in_array($status_filter, ['proses', 'selesai'])) {
    $sql .= " AND s.status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

if ($search) {
    $sql .= " AND (p.nama LIKE ? OR m.no_polisi LIKE ? OR m.merek LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= 'sss';
}

$sql .= " ORDER BY s.created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-wrench-adjustable"></i> Data Servis</h4>
    <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Servis</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        $msgs = [
            'added' => 'Servis berhasil dicatat. Status: Proses.',
            'finished' => 'Servis berhasil diselesaikan.'
        ];
        echo $msgs[$_GET['msg']] ?? 'Berhasil.';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari pelanggan / no polisi / merek..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="proses" <?= $status_filter === 'proses' ? 'selected' : '' ?>>Proses</option>
                    <option value="selesai" <?= $status_filter === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Filter</button>
            </div>
            <div class="col-md-2">
                <a href="index.php" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Mobil</th>
                        <th>Keluhan</th>
                        <th>Tgl Masuk</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                <td><?= htmlspecialchars($row['no_polisi']) ?><br><small class="text-muted"><?= htmlspecialchars($row['merek'].' '.$row['tipe']) ?></small></td>
                                <td><?= htmlspecialchars(mb_strimwidth($row['keluhan'], 0, 35, '...')) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_masuk'])) ?></td>
                                <td>Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($row['status'] === 'proses'): ?>
                                        <span class="badge badge-proses text-white">Proses</span>
                                    <?php else: ?>
                                        <span class="badge badge-selesai text-white">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'proses'): ?>
                                        <a href="selesai.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success"
                                           onclick="return confirm('Tandai servis sebagai selesai?')">
                                            <i class="bi bi-check2-circle"></i> Selesai
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data servis</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
