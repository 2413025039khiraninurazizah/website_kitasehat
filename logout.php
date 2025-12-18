<?php
session_start();
session_destroy(); // Hapus semua sesi login (Logout)

// Arahkan kembali ke Halaman Beranda Utama
header("Location: index.php"); 
exit;
?>