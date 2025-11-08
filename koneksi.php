<?php
$server   = "localhost";
$username = "root";
$pass     = "";
$dbname   = "db_toko"; 

$conn = mysqli_connect($server, $username, $pass, $dbname);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>