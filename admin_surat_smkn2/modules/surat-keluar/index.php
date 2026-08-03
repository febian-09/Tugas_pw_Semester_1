<?php
include '../../config/koneksi.php';
include '../../includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Surat Keluar</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="tambah.php" class="btn btn-primary shadow-sm">Tambah Surat Baru</a>
    </div>
</div>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Data surat berhasil diproses dan diarsipkan otomatis ke server!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No. Lengkap</th>
                        <th>Kategori</th>
                        <th>Tujuan</th>
                        <th>Perihal</th>
                        <th>Tanggal Kirim</th>
                        <th>Arsip</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT sk.*, rk.nama as nama_kategori FROM surat_keluar sk 
                            JOIN ref_kategori rk ON sk.id_kategori = rk.id ORDER BY sk.id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><strong><?= $row['no_lengkap']; ?></strong></td>
                                <td><span class="badge bg-info text-dark"><?= $row['nama_kategori']; ?></span></td>
                                <td><?= $row['tujuan']; ?></td>
                                <td><?= $row['perihal']; ?></td>
                                <td><i class="bi bi-calendar3 me-1"></i> <?= date('d-m-Y', strtotime($row['tgl_kirim'])); ?></td>
                                <td>
                                    <?php if ($row['file'] != ""): ?>
                                        <a href="<?= $base_url; ?>uploads/surat-keluar/<?= $row['file']; ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-file-pdf"></i> Lihat File
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Tidak ada file</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="cetak.php?id=<?= $row['id']; ?>" target="_blank" class="btn btn-sm btn-success"><i class="bi bi-printer"></i> Cetak</a>
                                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Belum ada data surat keluar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>