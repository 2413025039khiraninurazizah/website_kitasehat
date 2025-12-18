<?php
require "koneksi.php";

// LOGIKA REGISTER
if (isset($_POST['register'])) {
    $username   = htmlspecialchars($_POST['username']);
    $email      = htmlspecialchars($_POST['email']);
    $password   = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];
    $role       = $_POST['role'];

    // Validasi Sederhana
    if ($password !== $konfirmasi) {
        echo "<script>alert('Password tidak sama!');</script>";
    } else {
        // Cek apakah username/email sudah ada?
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
        
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Username atau Email sudah terdaftar!');</script>";
        } else {
            // Enkripsi Password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Masukkan ke Database
            $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password_hash', '$role')";
            
            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('✅ BERHASIL DAFTAR! Silakan Login.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('❌ Gagal: " . mysqli_error($koneksi) . "');</script>";
            }
        }
    }
}
?>

<?php 
// Navigasi Tetap Tamu
$paksa_tamu = true;
include "Komponen/header.php"; 
?>

<section class="login-section">
    <div class="login-container">
        <h2>Daftar Akun Baru</h2>
        <p>Silakan lengkapi data diri Anda</p>

        <form class="login-form" method="POST">
            <input type="email" name="email" placeholder="Email" required autocomplete="off" />
            <input type="text" name="username" placeholder="Username" required autocomplete="off" />
            <input type="password" name="password" placeholder="Password" required />
            <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password" required />

            <select name="role" required>
                <option value="" disabled selected>-- Daftar Sebagai --</option>
                <option value="user">User (Pengunjung)</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="register">Sign Up</button>
        </form>

        <p class="login-note">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </p>
    </div>
</section>

<?php include "Komponen/footer.php"; ?>