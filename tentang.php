<?php 
// 1. NYALAKAN SAKLAR TAMU
// Ini akan memaksa header menampilkan menu: Beranda, Tentang, Kontak, Login
$paksa_tamu = true; 

// 2. Panggil Header
include "Komponen/header.php"; 
?>

<section class="tentang-section">
    <div class="tentang-box">
        <h2>Tentang SehatKita</h2>
        <p>
            SehatKita adalah platform informasi kesehatan yang membantu masyarakat
            mendapatkan edukasi tentang gaya hidup sehat, nutrisi, olahraga, 
            dan pemantauan status kesehatan melalui kalkulator BMI.
        </p>
        <p>
            Dibangun sebagai proyek pembelajaran Pemrograman Web, platform ini
            dikembangkan dengan fokus pada kemudahan akses, keakuratan informasi,
            dan tampilan yang ramah pengguna.
        </p>
    </div>
</section>

<?php include "Komponen/footer.php"; ?>