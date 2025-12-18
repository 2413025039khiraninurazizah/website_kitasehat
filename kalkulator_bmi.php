<?php
session_start();

// PERBAIKAN: Gunakan 'role' sesuai login.php sebelumnya.
// Ini aman, Admin dan User bisa masuk sini tanpa saling ganggu.
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi
$bmi = "";
$status = "";
$kelas_hasil = ""; // Kita pakai class CSS, bukan kode warna langsung
$penyebab = "";
$solusi = "";
$rekomendasi = "";
$tampilHasil = false;

// LOGIKA HITUNG
if (isset($_POST['hitung'])) {
    $berat = $_POST['berat'];
    $tinggi = $_POST['tinggi'];

    if ($berat > 0 && $tinggi > 0) {
        $tinggi_m = $tinggi / 100;
        $nilai_bmi = $berat / ($tinggi_m * $tinggi_m);
        $bmi = number_format($nilai_bmi, 1);
        $tampilHasil = true;

        // Tentukan Kategori & Class CSS
        if ($nilai_bmi < 18.5) {
            $status = "KEKURANGAN BERAT BADAN (KURUS)";
            $kelas_hasil = "hasil-kurus"; // Class CSS
            $penyebab = "Metabolisme cepat, kurang asupan kalori, atau stres.";
            $solusi = "Fokus surplus kalori. Makan lebih sering dengan porsi kecil tapi padat gizi.";
            $rekomendasi = "🥑 Alpukat, Kacang-kacangan, Susu, Daging Merah, Telur.";
        } elseif ($nilai_bmi >= 18.5 && $nilai_bmi <= 24.9) {
            $status = "BERAT BADAN NORMAL (IDEAL)";
            $kelas_hasil = "hasil-normal"; // Class CSS
            $penyebab = "Pola makan seimbang dan aktivitas fisik yang cukup.";
            $solusi = "Pertahankan gaya hidup sehat ini. Jangan lupa rutin cek kesehatan.";
            $rekomendasi = "🥗 Sayuran hijau, Buah-buahan, Ikan, Air putih yang cukup.";
        } elseif ($nilai_bmi >= 25 && $nilai_bmi <= 29.9) {
            $status = "KELEBIHAN BERAT BADAN (GEMUK)";
            $kelas_hasil = "hasil-gemuk"; // Class CSS
            $penyebab = "Asupan kalori berlebih, kurang gerak, atau faktor genetik.";
            $solusi = "Kurangi gula & gorengan. Lakukan kardio (jalan/lari) minimal 30 menit.";
            $rekomendasi = "🍎 Apel, Oatmeal, Dada Ayam Rebus, Teh Hijau.";
        } else {
            $status = "OBESITAS (BAHAYA)";
            $kelas_hasil = "hasil-obesitas"; // Class CSS
            $penyebab = "Pola hidup sedentari (malas gerak) & konsumsi junk food berlebihan.";
            $solusi = "Segera konsultasi ke dokter/ahli gizi. Mulai diet defisit kalori perlahan.";
            $rekomendasi = "🥦 Brokoli, Berries, Ikan Kukus, Hindari Minuman Manis.";
        }
    }
}
?>

<?php include "komponen/header.php"; ?>

<div class="turun-dong">
    
    <div class="bmi-intro">
        <h2 class="bmi-title">Kalkulator BMI</h2>
        <p class="bmi-subtitle">Cek kesehatanmu dan dapatkan saran ahli di sini.</p>
    </div>

    <div class="bmi-wrapper">
        
        <div class="bmi-card bmi-input-card">
            <h3 class="card-title">Masukkan Data</h3>
            
            <form method="POST">
                <div class="form-group">
                    <label>Berat Badan (kg)</label>
                    <input type="number" name="berat" placeholder="0" required value="<?php echo isset($_POST['berat']) ? $_POST['berat'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi" placeholder="0" required value="<?php echo isset($_POST['tinggi']) ? $_POST['tinggi'] : ''; ?>">
                </div>

                <button type="submit" name="hitung" class="btn-bmi-hitung">Hitung Sekarang</button>
            </form>
        </div>

        <?php if ($tampilHasil) { ?>
            <div class="bmi-card bmi-result-card">
                
                <div class="bmi-result-header <?php echo $kelas_hasil; ?>">
                    <span class="result-label">Angka BMI Kamu</span>
                    <h1 class="result-number"><?php echo $bmi; ?></h1>
                    <strong class="result-status"><?php echo $status; ?></strong>
                </div>

                <div class="bmi-result-body">
                    <div class="bmi-detail-item">
                        <span class="detail-label">❓ Penyebab:</span>
                        <p><?php echo $penyebab; ?></p>
                    </div>
                    
                    <div class="bmi-detail-item">
                        <span class="detail-label">💡 Solusi:</span>
                        <p><?php echo $solusi; ?></p>
                    </div>

                    <div class="bmi-detail-item">
                        <span class="detail-label">🍽️ Rekomendasi:</span>
                        <p><?php echo $rekomendasi; ?></p>
                    </div>

                    <a href="kalkulator_bmi.php" class="btn-reset">🔄 Reset Hitungan</a>
                </div>
            </div>
        
        <?php } else { ?>
            
            <div class="bmi-card bmi-empty-state">
                <div class="empty-content">
                    <span class="empty-icon">📊</span>
                    <p>Hasil hitungan akan muncul di sini.</p>
                </div>
            </div>

        <?php } ?>

    </div>
</div> 

<?php include "komponen/footer.php"; ?>