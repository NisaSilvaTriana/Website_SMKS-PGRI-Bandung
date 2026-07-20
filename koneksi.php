<?php
$host = "localhost"; 
$user = "u123456789_admin_sekolah"; 
$pass = "SmksPgriBandung15!";  
$db   = "db_sekolah";       

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>