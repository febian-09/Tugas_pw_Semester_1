<?php
require_once '../config/database.php';
require_once '../includes/header.php';

// Statistik
$total_buku     = $conn->query("SELECT COUNT(*) as total FROM buku")->fetch_assoc()['total'];
$total_anggota  = $conn->query("SELECT COUNT(*) as total FROM anggota")->fetch_assoc()['total'];
$dipinjam       = $conn->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dipinjam'")->fetch_assoc()['total'];
$dikembalikan   = $conn->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dikembalikan'")->fetch_assoc()['total'];
$total_stok     = $conn->query("SELECT SUM(stok) as total FROM buku")->fetch_assoc()['total'] ?? 0;

// Peminjaman terbaru
$peminjaman_terbaru = $conn->query("
    SELECT p.*, a.nama as nama_anggota, b.judul as judul_buku 
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku b ON p.id_buku = b.id
    ORDER BY p.created_at DESC
    LIMIT 5
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h4>
    <span class="text-muted">Selamat datang, <?= htmlspecialchars($user['nama']) ?>!</span>
</div>

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1 opacity-75">Total Buku</h6>
                        <h2 class="mb-0"><?= $total_buku ?></h2>
                    </div>
                    <i class="bi bi-book fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1 opacity-75">Total Anggota</h6>
                        <h2 class="mb-0"><?= $total_anggota ?></h2>
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
                        <h6 class="card-subtitle mb-1">Sedang Dipinjam</h6>
                        <h2 class="mb-0"><?= $dipinjam ?></h2>
                    </div>
                    <i class="bi bi-arrow-left-right fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-1 opacity-75">Total Stok</h6>
                        <h2 class="mb-0"><?= $total_stok ?></h2>
                    </div>
                    <i class="bi bi-stack fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Peminjaman Terbaru -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="bi bi-clock-history"></i> Peminjaman Terbaru</h6>
        <a href="peminjaman/index.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($peminjaman_terbaru->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $peminjaman_terbaru->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_kembali'])) ?></td>
                                <td>
                                    <?php if ($row['status'] === 'dipinjam'): ?>
                                        <span class="badge badge-status-dipinjam text-white">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge badge-status-dikembalikan text-white">Dikembalikan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data peminjaman</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
