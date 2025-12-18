<?php

session_start();
include "koneksi.php";

// CEK LOGIN & ROLE ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


// LOGIKA SIMPAN
if (isset($_POST['simpan'])) {
    $judul    = htmlspecialchars($_POST['judul']);
    $kategori = $_POST['kategori'];
    
    // ===============================================================
    // ⚠️ PERUBAHAN PENTING DI SINI!
    // Kita HAPUS 'htmlspecialchars' khusus untuk $isi.
    // Kenapa? Karena CKEditor mengirim data dalam bentuk HTML 
    // (contoh: <b>Tebal</b>), jadi kita harus terima apa adanya.
    // ===============================================================
    $isi      = $_POST['isi']; 
    
   $id_user = $_SESSION['user_id'];

    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];
    $folder = "uploads/"; 

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if ($gambar != "") {
        $nama_baru = rand(100, 999) . "_" . str_replace(" ", "_", $gambar);
        move_uploaded_file($tmp, $folder . $nama_baru);
    } else {
        $nama_baru = "default.jpg"; 
    }

    $query = "INSERT INTO artikel (judul, kategori, isi, gambar, id_user, tanggal) 
              VALUES ('$judul', '$kategori', '$isi', '$nama_baru', '$id_user', NOW())";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('✅ Artikel Berhasil Terbit dengan Format Keren!'); window.location='kelola_artikel.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<?php include "Komponen/header.php"; ?>

<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<style>
    .form-container {
        max-width: 900px; /* Lebarin dikit biar editornya lega */
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50; }
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }
</style>

<div class="turun-dong" style="background: #f4f6f9; min-height: 100vh; padding-top: 120px; padding-bottom: 50px;">
    
    <div class="form-container">
        <h2 style="color: #27ae60; margin-bottom: 5px;">✍️ Tulis Artikel (Editor Canggih)</h2>
        <p style="color: #666; margin-bottom: 30px;">Gunakan toolbar di bawah untuk mengatur gaya tulisan.</p>

        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Judul Artikel</label>
                <input type="text" name="judul" class="form-control" placeholder="Judul artikel..." required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="fisik">Fisik</option>
                        <option value="emosional">Emosional</option>
                        <option value="gaya hidup">Gaya Hidup</option>
                        <option value="nutrisi">Nutrisi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Gambar Utama</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea name="isi" id="isi_artikel" class="form-control" required></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" name="simpan" class="btn-hero" style="border:none; cursor:pointer; width: 100%; background: #27ae60; color: white; padding: 15px; border-radius: 8px; font-weight: bold;">
                    🚀 Terbitkan Sekarang
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    // Perintah untuk mengubah textarea biasa menjadi CKEditor
    CKEDITOR.replace('isi_artikel');
</script>

<?php include "Komponen/footer.php"; ?>