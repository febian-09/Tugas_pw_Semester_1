<?php
include "koneksi.php";
$data = mysqli_query($conn,"SELECT * FROM siswa");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
</head>
<body>

<h2>DATA SISWA</h2>

<a href="tambah.php">Tambah Data</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>No</th>
    <th>NISN</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Aksi</th>
</tr>

<?php
$no=1;
while($d=mysqli_fetch_array($data)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nisn']; ?></td>
    <td><?= $d['nama']; ?></td>
    <td><?= $d['kelas']; ?></td>
    <td>
        <a href="edit.php?nisn=<?= $d['nisn']; ?>">Edit</a> |
        <a href="hapus.php?nisn=<?= $d['nisn']; ?>" onclick="return confirm('Hapus Data?')">Hapus</a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>