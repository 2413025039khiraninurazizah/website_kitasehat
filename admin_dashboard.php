<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


// QUERY ARTIKEL TERBARU (Limit 3)
$query = "SELECT * FROM artikel ORDER BY id DESC LIMIT 3";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SehatKita</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "Komponen/header.php"; ?>

<div class="hero-admin">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>Halo, <span class="highlight-name"><?php echo htmlspecialchars($_SESSION['username']); ?>
!</span></h1>
            <p>Selamat datang di Pusat Kontrol SehatKita.</p>
            <p class="hero-desc">Kelola artikel, pantau kesehatan pengguna, dan bagikan inspirasi hidup sehat dari sini.</p>
            
            <div class="hero-buttons">
                <a href="tambah_artikel.php" class="btn-hero-primary">+ Tulis Artikel</a>
                <a href="kelola_artikel.php" class="btn-hero-secondary">Kelola Tulisan</a>
            </div>
        </div>
    </div>
</div>

<div class="turun-dong container-dashboard">
    
    <div class="section-header">
        <h2>🔥 Baru Saja Terbit</h2>
        <a href="artikel.php" class="link-lihat-semua">Lihat Semua Artikel →</a>
    </div>

    <div class="artikel-grid">
        
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
        ?>
            <div class="card-dashboard">
                <div class="card-img-wrapper">
                    <img src="<?php echo $row['gambar']; ?>" alt="Gambar Artikel">
                </div>
                
                <div class="card-body">
                    <span class="badge-kategori"><?php echo ucfirst($row['kategori']); ?></span>
                    <h3><?php echo substr($row['judul'], 0, 50); ?>...</h3>
                    
                    <a href="baca_artikel.php?id=<?php echo $row['id']; ?>" class="btn-baca-mini">
                        📖 Baca
                    </a>
                </div>
            </div>

        <?php 
            } 
        } else { 
        ?>
            <div class="empty-state">
                <p>Belum ada artikel. Yuk mulai menulis!</p>
            </div>
        <?php } ?>

    </div>

</div>

<?php include "Komponen/footer.php"; ?>

</body>
</html>