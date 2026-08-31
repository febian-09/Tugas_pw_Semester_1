<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Hapus buku
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM buku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?msg=deleted");
    exit;
}

// Pencarian
$search = trim($_GET['search'] ?? '');
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR penerbit LIKE ? ORDER BY id DESC");
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM buku ORDER BY id DESC");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-book-half"></i> Data Buku</h4>
    <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Buku</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        $msgs = ['added' => 'Buku berhasil ditambahkan.', 'updated' => 'Buku berhasil diubah.', 'deleted' => 'Buku berhasil dihapus.'];
        echo $msgs[$_GET['msg']] ?? 'Berhasil.';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari judul, penulis, atau penerbit..." value="<?= htmlspecialchars($search) ?>">
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
                        <th width="50">No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['judul']) ?></td>
                                <td><?= htmlspecialchars($row['penulis']) ?></td>
                                <td><?= htmlspecialchars($row['penerbit'] ?? '-') ?></td>
                                <td><?= $row['tahun'] ?? '-' ?></td>
                                <td>
                                    <span class="badge <?= $row['stok'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $row['stok'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" title="Hapus"
                                       onclick="return confirm('Yakin ingin menghapus buku ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Tidak ada data buku</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
