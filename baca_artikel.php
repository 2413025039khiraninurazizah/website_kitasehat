<?php
session_start();
include "koneksi.php";

// 1. AMBIL ID DARI URL
$id_artikel = isset($_GET['id']) ? $_GET['id'] : '';

// 2. QUERY DATABASE
$query = "SELECT artikel.*, users.username AS penulis 
          FROM artikel 
          LEFT JOIN users ON artikel.id_user = users.id 
          WHERE artikel.id = '$id_artikel'";

$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Artikel tidak ditemukan!'); window.location='artikel.php';</script>";
    exit;
}

// --- LOGIKA TOMBOL KEMBALI (DIPERBARUI) ---
// Sekarang semua diarahkan ke halaman daftar artikel
$link_kembali = "artikel.php"; 
$teks_kembali = "Kembali ke Daftar Artikel";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['judul']; ?> - SehatKita</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include "komponen/header.php"; ?>

    <div class="baca-wrapper">
        
        <div class="baca-header">
            <span class="kategori-tag"><?php echo ucfirst($row['kategori']); ?></span>
            <h1 class="baca-judul"><?php echo $row['judul']; ?></h1>
            
            <div class="baca-meta">
                <span>👤 Penulis: <b><?php echo $row['penulis']; ?></b></span>
                <span>📅 Tanggal: <?php echo $row['tanggal']; ?></span>
            </div>
        </div>

        <div class="baca-img-container">
            <?php if (!empty($row['gambar'])): ?>
                <img src="<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>">
            <?php endif; ?>
        </div>

        <div class="baca-content">
            <?php echo $row['isi']; ?>
        </div>

        <div class="baca-footer">
            <a href="<?php echo $link_kembali; ?>" class="btn-kembali-baca">
                ← <?php echo $teks_kembali; ?>
            </a>
        </div>

    </div>

    <?php include "komponen/footer.php"; ?>

</body>
</html>