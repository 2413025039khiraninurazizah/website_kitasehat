<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SehatKita</title>
    
    <link rel="stylesheet" href="style.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header">
        <nav class="navbar">
            
            <div class="logo">
                <a href="<?php echo isset($_SESSION['admin_username']) ? 'admin_dashboard.php' : (isset($_SESSION['user']) ? 'user_dashboard.php' : 'index.php'); ?>" style="text-decoration:none; color:inherit;">
                    Sehat<span>Kita</span>
                </a>
            </div>
            
            <ul class="nav-links">
                
                <?php 
                // ========================================================
                // 1. MENU TAMU (Saat Saklar $paksa_tamu dinyalakan)
                // ========================================================
                // Ini dipakai di halaman: Index, Tentang, Kontak, Login, Signup
                if (isset($paksa_tamu) && $paksa_tamu == true): 
                ?>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="tentang.php">Tentang</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="login.php" class="btn-login">Login</a></li>


                <?php 
                // ========================================================
                // 2. MENU ADMIN (SESUAI REQUEST TERBARU)
                // ========================================================
                elseif (isset($_SESSION['admin_username'])): 
                ?>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    
                    <li><a href="artikel.php">Artikel</a></li>

                    <li><a href="kalkulator_bmi.php">Kalkulator BMI</a></li>

                    <li><a href="kelola_artikel.php" style="color: #27ae60; font-weight: bold;">Kelola Punya Saya</a></li> 
                    
                    <li><a href="logout.php" class="btn-login" style="background-color: #e74c3c;">Logout</a></li>


                <?php 
                // ========================================================
                // 3. MENU USER BIASA
                // ========================================================
                elseif (isset($_SESSION['user'])): 
                ?>
                    <li><a href="user_dashboard.php">Beranda</a></li>
                    <li><a href="artikel.php">Baca Artikel</a></li>
                    <li><a href="kalkulator_bmi.php">Cek BMI</a></li>
                    <li><a href="logout.php" class="btn-logout" style="background-color: #e74c3c;">Logout</a></li>


                <?php 
                // ========================================================
                // 4. MENU DEFAULT (Jaga-jaga)
                // ========================================================
                else: 
                ?>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="tentang.php">Tentang</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="login.php" class="btn-login">Login</a></li>

                <?php endif; ?>
                
            </ul>
        </nav>
    </header>