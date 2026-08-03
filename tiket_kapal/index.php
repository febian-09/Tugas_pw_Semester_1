<?php
include "koneksi.php";

$cari = "";

if(isset($_GET['cari'])){
    $cari = $_GET['cari'];
}

$data = mysqli_query($conn,"
SELECT * FROM tiket_kapal
WHERE nama_penumpang LIKE '%$cari%'
OR nama_kapal LIKE '%$cari%'
ORDER BY id_tiket DESC
");

$total = mysqli_num_rows($data);

?>


<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<title>Data Tiket Kapal</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:30px;
}

h2{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th,td{
    border:1px solid black;
    padding:8px;
    text-align:center;
}

input{
    padding:6px;
    width:250px;
}

button,a{
    padding:6px 12px;
    border:1px solid black;
    background:white;
    color:black;
    text-decoration:none;
}

</style>

</head>


<body>


<h2>Data Tiket Kapal</h2>


<p>
<b>Total Data :</b> <?= $total; ?>
</p>


<a href="tambah.php">
Tambah Data
</a>


<br><br>


<form method="GET">

<input 
type="text"
name="cari"
placeholder="Cari nama penumpang atau kapal"
value="<?= $cari; ?>"
>

<button type="submit">
Cari
</button>

</form>



<table>


<tr>

<th>ID</th>
<th>Nama Penumpang</th>
<th>Nama Kapal</th>
<th>Asal</th>
<th>Tujuan</th>
<th>Tanggal</th>
<th>Harga</th>
<th>Aksi</th>

</tr>



<?php

if(mysqli_num_rows($data)>0){

while($d=mysqli_fetch_assoc($data)){

?>


<tr>

<td><?= $d['id_tiket']; ?></td>

<td><?= $d['nama_penumpang']; ?></td>

<td><?= $d['nama_kapal']; ?></td>

<td><?= $d['pelabuhan_asal']; ?></td>

<td><?= $d['pelabuhan_tujuan']; ?></td>

<td>
<?= date('d-m-Y',strtotime($d['tanggal_berangkat'])); ?>
</td>

<td>
Rp <?= number_format($d['harga'],0,',','.'); ?>
</td>


<td>

<a href="edit.php?id=<?= $d['id_tiket']; ?>">
Edit
</a>


<a href="hapus.php?id=<?= $d['id_tiket']; ?>"
onclick="return confirm('Yakin ingin menghapus data ini?')">
Hapus
</a>


</td>


</tr>


<?php

}

}else{

?>

<tr>

<td colspan="8">
Data tidak ditemukan
</td>

</tr>

<?php

}

?>


</table>


</body>

</html>