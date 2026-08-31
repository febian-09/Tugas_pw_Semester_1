<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Filter status
$status_filter = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

$sql = "SELECT p.*, a.nama as nama_anggota, b.judul as judul_buku, u.nama as nama_petugas
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON p.id_buku = b.id
        JOIN users u ON p.id_petugas = u.id
        WHERE 1=1";

$params = [];
$types = '';

if ($status_filter && in_array($status_filter, ['dipinjam', 'dikembalikan'])) {
    $sql .= " AND p.status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

if ($search) {
    $sql .= " AND (a.nama LIKE ? OR b.judul LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-arrow-left-right"></i> Data Peminjaman</h4>
    <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Pinjam Buku</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        $msgs = [
            'added' => 'Peminjaman berhasil dicatat. Stok buku otomatis berkurang.',
            'returned' => 'Buku berhasil dikembalikan. Stok otomatis bertambah.'
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
                <input type="text" name="search" class="form-control" placeholder="Cari nama anggota atau judul buku..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" <?= $status_filter === 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                    <option value="dikembalikan" <?= $status_filter === 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
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
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Petugas</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                <td><?= htmlspecialchars($row['nama_petugas']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_kembali'])) ?></td>
                                <td>
                                    <?php if ($row['status'] === 'dipinjam'): ?>
                                        <span class="badge badge-status-dipinjam text-white">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge badge-status-dikembalikan text-white">Dikembalikan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['denda'] > 0): ?>
                                        <span class="text-danger">Rp <?= number_format($row['denda'], 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'dipinjam'): ?>
                                        <a href="kembali.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success" title="Kembalikan"
                                           onclick="return confirm('Konfirmasi pengembalian buku?')">
                                            <i class="bi bi-check2-circle"></i> Kembali
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Tidak ada data peminjaman</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
