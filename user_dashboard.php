<?php
session_start();
require "koneksi.php";

// CEK LOGIN USER
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
?>

<?php include "komponen/header.php"; ?>

<section class="hero hero-user">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                Halo, 
                <span class="text-highlight">
                    <?= htmlspecialchars($_SESSION['username']); ?>
                </span>!
            </h1>
            <p>Sehat itu investasi masa depan. Mulai langkah kecilmu hari ini.</p>
        </div>
    </div>
</section>

<section class="section-container">

    <div style="
        background: linear-gradient(135deg, #a8e063 0%, #56ab2f 100%);
        padding: 30px;
        border-radius: 15px;
        color: white;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    ">
        <div>
            <h2 style="margin: 0 0 5px 0;">Sudah cek kesehatanmu?</h2>
            <p style="margin: 0; opacity: 0.9;">
                Ketahui Indeks Massa Tubuh (BMI) kamu sekarang juga.
            </p>
        </div>
        <a href="kalkulator_bmi.php" class="btn-bmi">
            Cek BMI Sekarang →
        </a>
    </div>

    <div class="section-header">
        <h2 class="section-title">📚 Bacaan Terbaru</h2>
        <a href="artikel.php" class="link-more">Cari Artikel Lain →</a>
    </div>

    <div class="admin-grid">
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM artikel ORDER BY id DESC LIMIT 3");
        while ($data = mysqli_fetch_assoc($query)) {
            $badge_class = "badge-" . strtolower($data['kategori']);
        ?>
        <div class="artikel-card admin-card">
            <img src="<?= $data['gambar']; ?>" class="card-img"
                 onerror="this.src='https://via.placeholder.com/300'">

            <div class="card-content">
                <span class="kategori-badge <?= $badge_class; ?>">
                    <?= ucfirst($data['kategori']); ?>
                </span>

                <h3 class="card-title"><?= $data['judul']; ?></h3>

                <p class="card-desc">
                    <?= substr(strip_tags($data['isi']), 0, 80); ?>...
                </p>

                <a href="baca_artikel.php?id=<?= $data['id']; ?>" class="btn-action btn-green">
                    📖 Baca
                </a>
            </div>
        </div>
        <?php } ?>
    </div>

</section>

<?php include "komponen/footer.php"; ?>
