<?php
session_start();
require "koneksi.php";

// 1. TANGKAP KATA KUNCI PENCARIAN & KATEGORI
$keyword = isset($_GET['q']) ? $_GET['q'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// 2. RACIK QUERY DATABASE
$queryStr = "SELECT * FROM users INNER JOIN artikel ON users.id = artikel.id_user WHERE 1=1";

// Filter Keyword
if (!empty($keyword)) {
    $queryStr .= " AND judul LIKE '%$keyword%'";
}

// Filter Kategori
if (!empty($kategori)) {
    $queryStr .= " AND kategori = '$kategori'";
}

// Urutkan terbaru
$queryStr .= " ORDER BY artikel.id DESC";

// Eksekusi
$result = mysqli_query($koneksi, $queryStr);
?>

<?php include "komponen/header.php"; ?>

<div class="turun-dong">
    
    <h2 class="judul-center">Jelajahi Semua Artikel</h2>

    <form action="" method="GET" class="search-wrapper">
        
        <input type="text" name="q" placeholder="🔍 Cari judul artikel..." 
               class="input-cari-artikel" 
               value="<?php echo htmlspecialchars($keyword); ?>" 
               autocomplete="off">

        <select name="kategori" class="select-kategori-artikel" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <option value="fisik" <?php if($kategori == 'fisik') echo 'selected'; ?>>💪 Fisik</option>
            <option value="mental" <?php if($kategori == 'mental') echo 'selected'; ?>>🧠 Mental</option>
            <option value="emosional" <?php if($kategori == 'emosional') echo 'selected'; ?>>❤️ Emosional</option>
            <option value="sosial" <?php if($kategori == 'sosial') echo 'selected'; ?>>🤝 Sosial</option>
            <option value="spiritual" <?php if($kategori == 'spiritual') echo 'selected'; ?>>✨ Spiritual</option>
            <option value="lingkungan" <?php if($kategori == 'lingkungan') echo 'selected'; ?>>🌳 Lingkungan</option>
            <option value="reproduksi" <?php if($kategori == 'reproduksi') echo 'selected'; ?>>⚕️ Reproduksi</option>
        </select>

    </form>

    <div class="admin-grid">
        
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
        ?>
            <div class="artikel-card">
                <img src="<?php echo $row['gambar']; ?>" alt="Gambar Artikel" class="card-img-top">
                
                <div class="card-content">
                    <span class="kategori-badge badge-<?php echo strtolower($row['kategori']); ?>">
                        <?php echo ucfirst($row['kategori']); ?>
                    </span>

                    <h3><?php echo $row['judul']; ?></h3>
                    
                    <p><?php echo substr(strip_tags($row['isi']), 0, 100); ?>...</p>

                    <a href="baca_artikel.php?id=<?php echo $row['id']; ?>" class="btn-baca">
                        📖 Baca Selengkapnya
                    </a>
                </div>
            </div>

        <?php 
            } // End While
        } else { 
        ?>
            
            <div class="not-found-box">
                <h1 style="font-size: 3rem;">📄❌</h1> 
                <h3>Maaf, artikel tidak ditemukan.</h3>
                <p>Coba cari dengan kata kunci lain atau pilih kategori berbeda.</p>
                <a href="artikel.php" style="color: #4caf50; font-weight: bold; text-decoration: none;">🔄 Reset Pencarian</a>
            </div>

        <?php } ?>

    </div>

</div> <?php include "komponen/footer.php"; ?>