<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Ringkasan
$total_peminjaman = $conn->query("SELECT COUNT(*) as total FROM peminjaman")->fetch_assoc()['total'];
$sedang_dipinjam  = $conn->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dipinjam'")->fetch_assoc()['total'];
$sudah_kembali    = $conn->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dikembalikan'")->fetch_assoc()['total'];
$total_denda      = $conn->query("SELECT SUM(denda) as total FROM peminjaman")->fetch_assoc()['total'] ?? 0;

// Buku paling sering dipinjam
$buku_populer = $conn->query("
    SELECT b.judul, COUNT(p.id) as jumlah
    FROM peminjaman p
    JOIN buku b ON p.id_buku = b.id
    GROUP BY p.id_buku
    ORDER BY jumlah DESC
    LIMIT 5
");

// Anggota paling aktif
$anggota_aktif = $conn->query("
    SELECT a.nama, COUNT(p.id) as jumlah
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    GROUP BY p.id_anggota
    ORDER BY jumlah DESC
    LIMIT 5
");

// Peminjaman yang terlambat (masih dipinjam & lewat tanggal kembali)
$terlambat = $conn->query("
    SELECT p.*, a.nama as nama_anggota, b.judul as judul_buku,
           DATEDIFF(CURDATE(), p.tanggal_kembali) as hari_terlambat
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku b ON p.id_buku = b.id
    WHERE p.status = 'dipinjam' AND p.tanggal_kembali < CURDATE()
    ORDER BY hari_terlambat DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-file-earmark-text"></i> Laporan</h4>
</div>

<!-- Ringkasan -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Total Transaksi</h6>
                <h3><?= $total_peminjaman ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Sedang Dipinjam</h6>
                <h3 class="text-warning"><?= $sedang_dipinjam ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Sudah Dikembalikan</h6>
                <h3 class="text-success"><?= $sudah_kembali ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Total Denda</h6>
                <h3 class="text-danger">Rp <?= number_format($total_denda, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Buku Populer -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-trophy"></i> Buku Paling Sering Dipinjam</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th width="80">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($buku_populer->num_rows > 0): ?>
                            <?php while ($row = $buku_populer->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['judul']) ?></td>
                                    <td><span class="badge bg-primary"><?= $row['jumlah'] ?></span></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Anggota Aktif -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-person-check"></i> Anggota Paling Aktif</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th width="80">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($anggota_aktif->num_rows > 0): ?>
                            <?php while ($row = $anggota_aktif->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><span class="badge bg-success"><?= $row['jumlah'] ?></span></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Keterlambatan -->
<div class="card">
    <div class="card-header bg-white">
        <h6 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle"></i> Peminjaman Terlambat (Masih Dipinjam)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Harus Kembali</th>
                        <th>Hari Terlambat</th>
                        <th>Estimasi Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($terlambat->num_rows > 0): ?>
                        <?php while ($row = $terlambat->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_kembali'])) ?></td>
                                <td><span class="badge bg-danger"><?= $row['hari_terlambat'] ?> hari</span></td>
                                <td class="text-danger">Rp <?= number_format($row['hari_terlambat'] * 1000, 0, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tidak ada keterlambatan 🎉</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
