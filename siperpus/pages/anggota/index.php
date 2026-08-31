<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Hapus anggota
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM anggota WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?msg=deleted");
    exit;
}

// Pencarian
$search = trim($_GET['search'] ?? '');
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE nama LIKE ? OR email LIKE ? OR no_hp LIKE ? ORDER BY id DESC");
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM anggota ORDER BY id DESC");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people"></i> Data Anggota</h4>
    <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Anggota</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        $msgs = ['added' => 'Anggota berhasil ditambahkan.', 'updated' => 'Anggota berhasil diubah.', 'deleted' => 'Anggota berhasil dihapus.'];
        echo $msgs[$_GET['msg']] ?? 'Berhasil.';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau no HP..." value="<?= htmlspecialchars($search) ?>">
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" title="Hapus"
                                       onclick="return confirm('Yakin ingin menghapus anggota ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data anggota</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
