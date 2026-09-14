<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$total_mobil     = $conn->query("SELECT COUNT(*) as total FROM mobil")->fetch_assoc()['total'];
$total_pelanggan = $conn->query("SELECT COUNT(*) as total FROM pelanggan")->fetch_assoc()['total'];
$proses          = $conn->query("SELECT COUNT(*) as total FROM servis WHERE status = 'proses'")->fetch_assoc()['total'];
$selesai         = $conn->query("SELECT COUNT(*) as total FROM servis WHERE status = 'selesai'")->fetch_assoc()['total'];
$total_pendapatan = $conn->query("SELECT SUM(biaya) as total FROM servis WHERE status = 'selesai'")->fetch_assoc()['total'] ?? 0;

$servis_terbaru = $conn->query("
    SELECT s.*, p.nama as nama_pelanggan, m.no_polisi, m.merek, m.tipe
    FROM servis s
    JOIN pelanggan p ON s.id_pelanggan = p.id
    JOIN mobil m ON s.id_mobil = m.id
    ORDER BY s.created_at DESC
    LIMIT 5
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h4>
    <span class="text-muted">Selamat datang, <?= htmlspecialchars($user['nama']) ?>!</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card text-white" style="background: linear-gradient(135deg, #1e3a5f, #334155);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1 opacity-75">Total Mobil</h6>
                        <h2 class="mb-0"><?= $total_mobil ?></h2>
                    </div>
                    <i class="bi bi-car-front fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1 opacity-75">Total Pelanggan</h6>
                        <h2 class="mb-0"><?= $total_pelanggan ?></h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1">Sedang Proses</h6>
                        <h2 class="mb-0"><?= $proses ?></h2>
                    </div>
                    <i class="bi bi-wrench-adjustable fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1 opacity-75">Pendapatan</h6>
                        <h5 class="mb-0">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h5>
                    </div>
                    <i class="bi bi-cash-stack fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="bi bi-clock-history"></i> Servis Terbaru</h6>
        <a href="servis/index.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
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
                    </tr>
                </thead>
                <tbody>
                    <?php if ($servis_terbaru->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $servis_terbaru->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                <td><?= htmlspecialchars($row['no_polisi']) ?> (<?= htmlspecialchars($row['merek'].' '.$row['tipe']) ?>)</td>
                                <td><?= htmlspecialchars(mb_strimwidth($row['keluhan'], 0, 40, '...')) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_masuk'])) ?></td>
                                <td>Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($row['status'] === 'proses'): ?>
                                        <span class="badge badge-proses text-white">Proses</span>
                                    <?php else: ?>
                                        <span class="badge badge-selesai text-white">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data servis</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
