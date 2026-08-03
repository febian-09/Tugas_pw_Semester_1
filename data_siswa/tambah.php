<?php
include "koneksi.php";

if(isset($_POST['simpan'])){
    mysqli_query($conn,"INSERT INTO siswa VALUES(
        '$_POST[nisn]',
        '$_POST[nama]',
        '$_POST[kelas]'
    )");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Data</title>
</head>
<body>

<h2>Tambah Data Siswa</h2>

<form method="post">

NISN<br>
<input type="text" name="nisn"><br><br>

Nama<br>
<input type="text" name="nama"><br><br>

Kelas<br>
<input type="text" name="kelas"><br><br>

<input type="submit" name="simpan" value="Simpan">
<input type="reset" value="Reset">
<a href="index.php">Kembali</a>

</form>

</body>
</html>