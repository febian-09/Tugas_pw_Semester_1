<?php
include '../../config/koneksi.php';
include '../../includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Surat Masuk</h1>
    <a href="tambah.php" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Surat Masuk
    </a>
</div>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
            if($_GET['status'] == 'sukses') echo "Data surat masuk berhasil ditambahkan!";
            if($_GET['status'] == 'update_sukses') echo "Perubahan data surat masuk berhasil disimpan!";
            if($_GET['status'] == 'hapus_sukses') echo "Data surat masuk telah dihapus!";
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
                        <th>No. Surat Asal</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Tgl Terima</th> <th>Arsip</th>      <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menggunakan koneksi $conn untuk mengambil data terbaru di baris paling atas
                    $sql = "SELECT * FROM surat_masuk ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?= $row['no_surat_asal']; ?></td>
                                <td><?= $row['pengirim']; ?></td>
                                <td><?= $row['perihal']; ?></td>
                                
                                <td><i class="bi bi-calendar3 me-1"></i> <?= date('d-m-Y', strtotime($row['tgl_terima'])); ?></td>
                                
                                <td>
                                    <?php if ($row['file'] != ""): ?>
                                        <a href="<?= $base_url; ?>uploads/surat-masuk/<?= $row['file']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="bi bi-x-circle"></i> Tidak ada file</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data surat masuk.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>