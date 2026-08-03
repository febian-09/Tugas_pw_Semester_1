<?php
include "koneksi.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM tiket_kapal WHERE id_tiket='$id'");

    header("Location:index.php");
    exit;

}else{

    header("Location:index.php");
    exit;

}

?>