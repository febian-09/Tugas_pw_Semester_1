<?php
include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM tiket_kapal WHERE id_tiket='$id'");
$d = mysqli_fetch_assoc($data);


if(isset($_POST['update'])){

    mysqli_query($conn,"
    UPDATE tiket_kapal SET
    nama_penumpang='$_POST[nama]',
    nomor_ktp='$_POST[ktp]',
    nama_kapal='$_POST[kapal]',
    pelabuhan_asal='$_POST[asal]',
    pelabuhan_tujuan='$_POST[tujuan]',
    tanggal_berangkat='$_POST[tanggal]',
    harga='$_POST[harga]'
    WHERE id_tiket='$id'
    ");

    header("Location:index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Edit Tiket Kapal</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin: 30px;
}

h2{
    text-align:center;
}

table{
    margin:auto;
    border-collapse:collapse;
}

td{
    padding:8px;
}

input{
    width:300px;
    padding:6px;
}

button, a{
    padding:7px 15px;
    text-decoration:none;
    border:1px solid black;
    background:white;
    color:black;
}

</style>

</head>


<body>


<h2>Edit Data Tiket Kapal</h2>


<form method="POST">

<table border="1">


<tr>
<td>Nama Penumpang</td>
<td>
<input type="text" name="nama" value="<?= $d['nama_penumpang']; ?>" required>
</td>
</tr>


<tr>
<td>Nomor KTP</td>
<td>
<input type="text" name="ktp" value="<?= $d['nomor_ktp']; ?>" required>
</td>
</tr>


<tr>
<td>Nama Kapal</td>
<td>
<input type="text" name="kapal" value="<?= $d['nama_kapal']; ?>" required>
</td>
</tr>


<tr>
<td>Pelabuhan Asal</td>
<td>
<input type="text" name="asal" value="<?= $d['pelabuhan_asal']; ?>" required>
</td>
</tr>


<tr>
<td>Pelabuhan Tujuan</td>
<td>
<input type="text" name="tujuan" value="<?= $d['pelabuhan_tujuan']; ?>" required>
</td>
</tr>


<tr>
<td>Tanggal Berangkat</td>
<td>
<input type="date" name="tanggal" value="<?= $d['tanggal_berangkat']; ?>" required>
</td>
</tr>


<tr>
<td>Harga Tiket</td>
<td>
<input type="number" name="harga" value="<?= $d['harga']; ?>" required>
</td>
</tr>


<tr>
<td></td>
<td>

<button type="submit" name="update">
Simpan
</button>

<a href="index.php">
Kembali
</a>

</td>
</tr>


</table>

</form>


</body>
</html>