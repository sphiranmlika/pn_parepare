<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pn_parepare"; // ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
