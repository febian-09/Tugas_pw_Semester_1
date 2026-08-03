<?php
include '../../config/koneksi.php';
include '../../includes/header.php';

// Proteksi tambahan: Hanya admin yang boleh masuk ke halaman manajemen user
if ($_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses ditolak! Hanya Administrator yang boleh mengelola user.'); window.location='../../index.php';</script>";
    exit();
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Pengguna</h1>
    <a href="tambah.php" class="btn btn-dark shadow-sm">
        <i class="bi bi-person-plus"></i> Tambah User Baru
    </a>
</div>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
            if($_GET['status'] == 'update_sukses') echo "Data user berhasil diperbarui!";
            if($_GET['status'] == 'hapus_sukses') echo "User berhasil dihapus!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= $row['username']; ?></strong></td>
                            <td><?= $row['nama_lengkap']; ?></td>
                            <td>
                                <span class="badge <?= $row['role'] == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                    <?= strtoupper($row['role']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <?php if ($row['id'] != $_SESSION['id_user']): ?>
                                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>