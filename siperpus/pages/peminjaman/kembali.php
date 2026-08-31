<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
cekLogin();

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header("Location: index.php");
    exit;
}

// Ambil data peminjaman
$stmt = $conn->prepare("SELECT * FROM peminjaman WHERE id = ? AND status = 'dipinjam'");
$stmt->bind_param("i", $id);
$stmt->execute();
$pinjam = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$pinjam) {
    header("Location: index.php");
    exit;
}

// Hitung denda (Rp 1000 per hari keterlambatan)
$tanggal_hari_ini = date('Y-m-d');
$tgl_kembali = $pinjam['tanggal_kembali'];
$denda = 0;

if ($tanggal_hari_ini > $tgl_kembali) {
    $diff = (strtotime($tanggal_hari_ini) - strtotime($tgl_kembali)) / (60 * 60 * 24);
    $denda = (int)$diff * 1000; // Rp 1.000 per hari
}

// Proses pengembalian
$conn->begin_transaction();
try {
    // Update status & denda
    $stmt = $conn->prepare("UPDATE peminjaman SET status = 'dikembalikan', tanggal_dikembalikan = ?, denda = ? WHERE id = ?");
    $stmt->bind_param("sii", $tanggal_hari_ini, $denda, $id);
    $stmt->execute();
    $stmt->close();

    // Tambah stok kembali
    $stmt = $conn->prepare("UPDATE buku SET stok = stok + 1 WHERE id = ?");
    $stmt->bind_param("i", $pinjam['id_buku']);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    header("Location: index.php?msg=returned");
    exit;
} catch (Exception $e) {
    $conn->rollback();
    die("Gagal mengembalikan buku: " . $e->getMessage());
}
?>
