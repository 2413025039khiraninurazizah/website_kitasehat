<?php
session_start();
require "koneksi.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi!";
    } else {

        // CEK USER SUDAH ADA
        $cek = mysqli_query($koneksi,
            "SELECT * FROM users WHERE username='$username' OR email='$email'"
        );

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau Email sudah terdaftar!";
        } else {

            // HASH PASSWORD
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // ROLE DIKUNCI = USER
            $role = 'user';

            $simpan = mysqli_query($koneksi,
                "INSERT INTO users (username, email, password, role)
                 VALUES ('$username', '$email', '$password_hash', '$role')"
            );

            if ($simpan) {
                header("Location: login.php?register=success");
                exit;
            } else {
                $error = "Registrasi gagal!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar SehatKita</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(rgba(0,0,0,.55), rgba(0,0,0,.55)),
    url('https://images.unsplash.com/photo-1497211419994-14ae40a3c7a3') center/cover no-repeat;
}

.register-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.register-box{
    background:#fff;
    width:380px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 15px 40px rgba(0,0,0,.2);
    text-align:center;
}

.register-box h2{
    margin-bottom:20px;
    color:#2e7d32;
}

.register-box input{
    width:100%;
    padding:11px;
    margin-bottom:14px;
    border:1px solid #ccc;
    border-radius:6px;
}

.register-box button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:#fff;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
}

.error-msg{
    background:#e74c3c;
    color:#fff;
    padding:10px;
    margin-bottom:12px;
    border-radius:6px;
}

.link-login{
    margin-top:15px;
    display:block;
    color:#2e7d32;
    text-decoration:none;
}
</style>
</head>

<body>

<?php include "komponen/header.php"; ?>

<div class="register-wrapper">
    <div class="register-box">
        <h2>Daftar SehatKita</h2>

        <?php if (isset($error)) { ?>
            <div class="error-msg"><?= $error ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="register">DAFTAR</button>
        </form>

        <a href="login.php" class="link-login">
            Sudah punya akun? Login
        </a>
    </div>
</div>

<?php include "komponen/footer.php"; ?>

</body>
</html>
