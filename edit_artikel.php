<?php
session_start();
include "koneksi.php";

// CEK LOGIN ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// AMBIL ID ARTIKEL DARI URL
$id_artikel = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// AMBIL ID ADMIN YANG LOGIN
$id_user_saya = $_SESSION['user_id'];

// AMBIL DATA ARTIKEL (PASTIKAN MILIK ADMIN INI)
$query = "SELECT * FROM artikel 
          WHERE id = '$id_artikel' 
          AND id_user = '$id_user_saya'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>
            alert('Artikel tidak ditemukan atau kamu tidak punya akses!');
            window.location='kelola_artikel.php';
          </script>";
    exit;
}


// 5. PROSES SIMPAN PERUBAHAN
if (isset($_POST['update'])) {
    $judul       = $_POST['judul'];
    $kategori    = $_POST['kategori'];
    $isi         = $_POST['isi']; // CKEditor content
    $link_gambar = $_POST['link_gambar']; // Inputan Link

    // --- LOGIKA GANTI GAMBAR ---
    $gambar_final = $data['gambar']; // Default: Pakai gambar lama

    // Cek 1: Apakah ada file yang diupload?
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_nama = $_FILES['gambar']['name'];
        $gambar_temp = $_FILES['gambar']['tmp_name'];
        $nama_unik   = rand(100,999) . '_' . $gambar_nama;
        
        move_uploaded_file($gambar_temp, 'uploads/' . $nama_unik);
        $gambar_final = 'uploads/' . $nama_unik; // Set gambar baru dari upload
    } 
    // Cek 2: Kalau tidak upload file, apakah ada Link Gambar?
    elseif (!empty($link_gambar)) {
        $gambar_final = $link_gambar; // Set gambar baru dari Link
    }
    
    // Update Database
    $query_update = "UPDATE artikel SET judul='$judul', kategori='$kategori', isi='$isi', gambar='$gambar_final' WHERE id='$id_artikel'";
    $run_update = mysqli_query($koneksi, $query_update);

    if ($run_update) {
        echo "<script>alert('Artikel berhasil diperbarui!'); window.location='kelola_artikel.php';</script>";
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "Komponen/header.php"; ?>

<div class="edit-container">
    <div class="edit-header">
        <h2>Edit Artikel</h2>
        <a href="kelola_artikel.php" class="btn-kembali">← Kembali</a>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" class="form-edit">
        
        <div class="form-group">
            <label>Judul Artikel</label>
            <input type="text" name="judul" value="<?php echo $data['judul']; ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="fisik" <?php if($data['kategori'] == 'fisik') echo 'selected'; ?>>Fisik</option>
                <option value="mental" <?php if($data['kategori'] == 'mental') echo 'selected'; ?>>Mental</option>
                <option value="emosional" <?php if($data['kategori'] == 'emosional') echo 'selected'; ?>>Emosional</option>
                <option value="sosial" <?php if($data['kategori'] == 'sosial') echo 'selected'; ?>>Sosial</option>
                <option value="spiritual" <?php if($data['kategori'] == 'spiritual') echo 'selected'; ?>>Spiritual</option>
                <option value="lingkungan" <?php if($data['kategori'] == 'lingkungan') echo 'selected'; ?>>Lingkungan</option>
                <option value="reproduksi" <?php if($data['kategori'] == 'reproduksi') echo 'selected'; ?>>Reproduksi</option>
            </select>
        </div>

        <div class="form-group">
            <label>Gambar Utama</label>
            
            <div class="img-preview-box">
                <img src="<?php echo $data['gambar']; ?>" alt="Gambar Lama" class="img-preview-old">
                <p class="img-note">Gambar saat ini. (Abaikan kolom di bawah jika tidak ingin ganti).</p>
            </div>

            <div class="gambar-options">
                <div class="option-item">
                    <label class="sub-label">📂 Opsi 1: Upload File Baru</label>
                    <input type="file" name="gambar">
                </div>
                
                <div class="option-divider">ATAU</div>

                <div class="option-item">
                    <label class="sub-label">🔗 Opsi 2: Masukkan Link Gambar (URL)</label>
                    <input type="text" name="link_gambar" placeholder="Contoh: https://website.com/foto.jpg">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Isi Artikel</label>
            <textarea name="isi" id="isi" required><?php echo $data['isi']; ?></textarea>
        </div>

        <button type="submit" name="update" class="btn-simpan">💾 Simpan Perubahan</button>
    </form>
</div>

<?php include "Komponen/footer.php"; ?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    // Konfigurasi tambahan biar warning benar-benar hilang
    CKEDITOR.replace( 'isi', {
        versionCheck: false 
    });
</script>

</body>
</html>