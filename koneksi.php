<?php
$host = 'localhost';
$db = 'perpustakaan1';
$user = 'root';
$pass = '';

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
