<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

    mysqli_query($conn,"
    INSERT INTO tiket_kapal VALUES(
    NULL,
    '$_POST[nama]',
    '$_POST[ktp]',
    '$_POST[kapal]',
    '$_POST[asal]',
    '$_POST[tujuan]',
    '$_POST[tanggal]',
    '$_POST[harga]'
    )
    ");

    header("Location:index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<title>Tambah Data Tiket Kapal</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:30px;
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

button,a{
    padding:7px 15px;
    border:1px solid black;
    background:white;
    color:black;
    text-decoration:none;
}

</style>

</head>


<body>


<h2>Tambah Data Tiket Kapal</h2>


<form method="POST">


<table border="1">


<tr>
<td>Nama Penumpang</td>
<td>
<input type="text" name="nama" required>
</td>
</tr>


<tr>
<td>Nomor KTP</td>
<td>
<input type="text" name="ktp" required>
</td>
</tr>


<tr>
<td>Nama Kapal</td>
<td>
<input type="text" name="kapal" required>
</td>
</tr>


<tr>
<td>Pelabuhan Asal</td>
<td>
<input type="text" name="asal" required>
</td>
</tr>


<tr>
<td>Pelabuhan Tujuan</td>
<td>
<input type="text" name="tujuan" required>
</td>
</tr>


<tr>
<td>Tanggal Berangkat</td>
<td>
<input type="date" name="tanggal" required>
</td>
</tr>


<tr>
<td>Harga Tiket</td>
<td>
<input type="number" name="harga" required>
</td>
</tr>


<tr>

<td></td>

<td>

<button type="submit" name="simpan">
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