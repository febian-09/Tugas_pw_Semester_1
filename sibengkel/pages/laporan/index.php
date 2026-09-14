<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$total_servis = $conn->query("SELECT COUNT(*) as total FROM servis")->fetch_assoc()['total'];
$proses       = $conn->query("SELECT COUNT(*) as total FROM servis WHERE status = 'proses'")->fetch_assoc()['total'];
$selesai      = $conn->query("SELECT COUNT(*) as total FROM servis WHERE status = 'selesai'")->fetch_assoc()['total'];
$total_pendapatan = $conn->query("SELECT SUM(biaya) as total FROM servis WHERE status = 'selesai'")->fetch_assoc()['total'] ?? 0;

$merek_populer = $conn->query("
    SELECT m.merek, COUNT(s.id) as jumlah
    FROM servis s
    JOIN mobil m ON s.id_mobil = m.id
    GROUP BY m.merek
    ORDER BY jumlah DESC
    LIMIT 5
");

$pelanggan_aktif = $conn->query("
    SELECT p.nama, COUNT(s.id) as jumlah
    FROM servis s
    JOIN pelanggan p ON s.id_pelanggan = p.id
    GROUP BY s.id_pelanggan
    ORDER BY jumlah DESC
    LIMIT 5
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-file-earmark-text"></i> Laporan</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Total Servis</h6>
                <h3><?= $total_servis ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Sedang Proses</h6>
                <h3 class="text-warning"><?= $proses ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Selesai</h6>
                <h3 class="text-success"><?= $selesai ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted">Total Pendapatan</h6>
                <h5 class="text-primary">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h5>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-trophy"></i> Merek Paling Sering Diservis</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Merek</th><th width="80">Jumlah</th></tr></thead>
                    <tbody>
                        <?php if ($merek_populer->num_rows > 0): ?>
                            <?php while ($row = $merek_populer->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['merek']) ?></td>
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
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-person-check"></i> Pelanggan Paling Aktif</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Nama</th><th width="80">Jumlah</th></tr></thead>
                    <tbody>
                        <?php if ($pelanggan_aktif->num_rows > 0): ?>
                            <?php while ($row = $pelanggan_aktif->fetch_assoc()): ?>
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

<?php require_once '../../includes/footer.php'; ?>
