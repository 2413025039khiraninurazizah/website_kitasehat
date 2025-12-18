<?php
session_start();
include "koneksi.php";

// CEK ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// AMBIL ID ADMIN YANG LOGIN
$id_saya = $_SESSION['user_id'];

// QUERY ARTIKEL SAYA
$query = "SELECT * FROM artikel WHERE id_user = '$id_saya' ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Saya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "Komponen/header.php"; ?>

<div class="kelola-container">
    
    <div class="kelola-header">
        <div>
            <h2 class="kelola-title">Artikel Saya</h2>
            <p class="kelola-subtitle">Hanya menampilkan artikel yang kamu tulis.</p>
        </div>
        <a href="tambah_artikel.php" class="btn-tambah">+ Tulis Artikel Baru</a>
    </div>

    <div class="table-wrapper">
        <table class="table-kelola">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="50%">Judul Artikel</th>
                    <th width="15%" style="text-align: center;">Kategori</th>
                    <th width="15%" style="text-align: center;">Tanggal</th>
                    <th width="15%" style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) { 
                ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no++; ?></td>
                        
                        <td>
                            <strong><?php echo $row['judul']; ?></strong>
                        </td>
                        
                        <td style="text-align: center;">
                            <span class="badge-kategori">
                                <?php echo ucfirst($row['kategori']); ?>
                            </span>
                        </td>
                        
                        <td style="text-align: center;">
                           <?php echo $row['tanggal']; ?>
                        </td>
                        
                        <td style="text-align: center;">
                            <a href="edit_artikel.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            
                            <a href="hapus_artikel.php?id=<?php echo $row['id']; ?>" 
                               class="btn-hapus" 
                               onclick="return confirm('Hapus artikel ini selamanya?');">
                               Hapus
                            </a>
                        </td>
                    </tr>

                <?php 
                    } // End While
                } else { 
                ?>
                    
                    <tr>
                        <td colspan="5" class="empty-row">
                            <span style="display:block; font-size: 2rem;">📭</span>
                            Kamu belum memiliki artikel apapun.
                        </td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>
    </div>

</div>

<?php include "Komponen/footer.php"; ?>

</body>
</html>