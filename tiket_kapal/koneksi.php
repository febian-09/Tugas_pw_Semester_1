<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_tiket_kapal1"
);

if(!$conn){
    die("Koneksi gagal : ".mysqli_connect_error());
}

?>