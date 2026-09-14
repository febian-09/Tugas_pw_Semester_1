<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM mobil WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?msg=deleted");
    exit;
}

$search = trim($_GET['search'] ?? '');
if ($search) {
    $stmt = $conn->prepare("
        SELECT m.*, p.nama as nama_pelanggan 
        FROM mobil m 
        JOIN pelanggan p ON m.id_pelanggan = p.id
        WHERE m.no_polisi LIKE ? OR m.merek LIKE ? OR m.tipe LIKE ? OR p.nama LIKE ?
        ORDER BY m.id DESC
    ");
    $like = "%$search%";
    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("
        SELECT m.*, p.nama as nama_pelanggan 
        FROM mobil m 
        JOIN pelanggan p ON m.id_pelanggan = p.id
        ORDER BY m.id DESC
    ");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-car-front"></i> Data Mobil</h4>
    <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Mobil</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        $msgs = ['added' => 'Mobil berhasil ditambahkan.', 'updated' => 'Mobil berhasil diubah.', 'deleted' => 'Mobil berhasil dihapus.'];
        echo $msgs[$_GET['msg']] ?? 'Berhasil.';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari no polisi, merek, tipe, atau pemilik..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Polisi</th>
                        <th>Merek / Tipe</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th>Pemilik</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['no_polisi']) ?></strong></td>
                                <td><?= htmlspecialchars($row['merek']) ?> <?= htmlspecialchars($row['tipe']) ?></td>
                                <td><?= $row['tahun'] ?? '-' ?></td>
                                <td><?= htmlspecialchars($row['warna'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin hapus mobil ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data mobil</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
