<?php
include "koneksi.php";

$nisn=$_GET['nisn'];

mysqli_query($conn,"DELETE FROM siswa WHERE nisn='$nisn'");

header("Location:index.php");
?>