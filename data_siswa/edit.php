<?php
include "koneksi.php";

$nisn=$_GET['nisn'];

$data=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM siswa WHERE nisn='$nisn'"));

if(isset($_POST['ubah'])){
    mysqli_query($conn,"UPDATE siswa SET
    nama='$_POST[nama]',
    kelas='$_POST[kelas]'
    WHERE nisn='$_POST[nisn]'");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Data</title>
</head>
<body>

<h2>Edit Data Siswa</h2>

<form method="post">

NISN<br>
<input type="text" name="nisn" value="<?= $data['nisn']; ?>" readonly><br><br>

Nama<br>
<input type="text" name="nama" value="<?= $data['nama']; ?>"><br><br>

Kelas<br>
<input type="text" name="kelas" value="<?= $data['kelas']; ?>"><br><br>

<input type="submit" name="ubah" value="Ubah">
<a href="index.php">Kembali</a>

</form>

</body>
</html>