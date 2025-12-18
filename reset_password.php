<?php
require "koneksi.php";

if (!isset($_GET['token'])) {
    die("Token tidak valid");
}

$token = $_GET['token'];

$stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE reset_token=?");
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    die("Token tidak valid atau sudah digunakan");
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update = mysqli_prepare(
        $koneksi,
        "UPDATE users SET password=?, reset_token=NULL WHERE id=?"
    );
    mysqli_stmt_bind_param($update, "si", $password, $data['id']);
    mysqli_stmt_execute($update);

    header("Location: login.php?reset=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reset Password | SehatKita</title>

<style>
/* SAMA KAYA FORGOT, BIAR KONSISTEN */
body{
    min-height:100vh;
    background: linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
    url('https://images.unsplash.com/photo-1497211419994-14ae40a3c7a3')
    center/cover no-repeat;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Poppins,sans-serif;
}

.box{
    background:#fff;
    width:360px;
    padding:30px;
    border-radius:12px;
    text-align:center;
}

.box h2{color:#2e7d32;margin-bottom:15px}

.box input{
    width:100%;
    padding:12px;
    margin-bottom:14px;
}

.box button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:#fff;
    border:none;
}
</style>
</head>

<body>

<div class="box">
    <h2>Reset Password</h2>

    <form method="POST">
        <input type="password" name="password" placeholder="Password Baru" required>
        <button type="submit">Simpan Password</button>
    </form>
</div>

</body>
</html>
