<?php 
session_start();
// ... kodingan php lain jika ada ...
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SehatKita - Hidup Sehat</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include "komponen/header.php"; ?>

    <div class="landing-wrapper" 
         style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1497211419994-14ae40a3c7a3?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGdyZWVufGVufDB8fDB8fHww') no-repeat center center / cover, #1b5e20;">
        
        <div class="konten-tengah">
            <h1>Pilihan Sehat Untuk Hidup Lebih Baik</h1>
            <p>Dapatkan berbagai informasi kesehatan, panduan gizi seimbang, dan hitung BMI kamu untuk menjaga gaya hidup sehat setiap hari.</p>
            
            <a href="login.php" class="btn-login-besar">Login Sekarang</a>
        </div>

    </div>

    <?php include "komponen/footer.php"; ?>

</body>
</html>