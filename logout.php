<?php
session_start();
session_destroy(); // Menghapus semua sesi yang ada
header("Location: index.php"); // Redirect ke halaman login
exit();
?>
