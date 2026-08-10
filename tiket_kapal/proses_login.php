<?php

session_start();

$username = $_POST['Username'];
$password = $_POST['Password'];

if ($username == "admin" && $password == "12345") {

    $_SESSION['Username'] = $username;

    header("Location: tampilan_data.php");
    exit();

} else {

    echo "<script>
        alert('Username atau password salah!');
        window.location.href = 'login.php';
    </script>";

}

?>