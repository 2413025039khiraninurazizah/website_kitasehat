<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' LIMIT 1");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['login']    = true;
        $_SESSION['id_user']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login SehatKita</title>

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

/* LOGIN */
.login-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-box{
    background:#fff;
    width:360px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 15px 40px rgba(0,0,0,.2);
    text-align:center;
}

.login-box h2{
    margin-bottom:20px;
    color:#2e7d32;
}

.login-box input,
.login-box select{
    width:100%;
    padding:11px;
    margin-bottom:14px;
    border:1px solid #ccc;
    border-radius:6px;
}

.login-box button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:#fff;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
}

.login-box button:hover{
    background:#27ae60;
}

.error-msg{
    background:#e74c3c;
    color:#fff;
    padding:10px;
    margin-bottom:12px;
    border-radius:6px;
}
</style>
</head>

<body>

<?php include "komponen/header.php"; ?>
<button type="submit">LOGIN</button>

<div class="login-wrapper">
    <div class="login-box">
        <h2>Login SehatKita</h2>

        <?php if (!empty($error)) { ?>
            <div class="error-msg"><?= $error ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="" disabled selected>Login sebagai</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
<div style="margin-top:15px; font-size:14px;">

    <p>
        <a href="forgot_password.php" style="color:#2e7d32; text-decoration:none;">
            Lupa Password?
        </a>
    </p>

    <p style="margin-top:8px;">
        Belum punya akun?
        <a href="register.php" style="color:#2e7d32; font-weight:bold;">
            Daftar Sekarang
        </a>
    </p>

</div>

            <button type="submit">LOGIN</button>
        </form>
    </div>
</div>

<?php include "komponen/footer.php"; ?>

</body>
</html>
