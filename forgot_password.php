<?php
session_start();
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $token = bin2hex(random_bytes(16));

        $update = mysqli_prepare(
            $koneksi,
            "UPDATE users SET reset_token=? WHERE email=?"
        );
        mysqli_stmt_bind_param($update, "ss", $token, $email);
        mysqli_stmt_execute($update);

        header("Location: forgot_password.php?sent=1&token=$token");
        exit;
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lupa Password | SehatKita</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
    url('https://images.unsplash.com/photo-1497211419994-14ae40a3c7a3')
    center/cover no-repeat;
}

/* WRAPPER */
.wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* BOX */
.box{
    background:#fff;
    width:360px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
    text-align:center;
}

.box h2{
    margin-bottom:15px;
    color:#2e7d32;
}

.box p{
    font-size:14px;
    color:#555;
    margin-bottom:15px;
}

.box input{
    width:100%;
    padding:12px;
    margin-bottom:14px;
    border:1px solid #ccc;
    border-radius:6px;
}

.box button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    border:none;
    border-radius:6px;
    color:#fff;
    font-weight:bold;
    cursor:pointer;
}

.box button:hover{
    background:#27ae60;
}

.error{
    background:#e74c3c;
    color:#fff;
    padding:10px;
    border-radius:6px;
    margin-bottom:12px;
}

.success{
    background:#2ecc71;
    color:#fff;
    padding:10px;
    border-radius:6px;
    margin-bottom:12px;
}

a{
    color:#2e7d32;
    text-decoration:none;
}
</style>
</head>

<body>

<?php include "komponen/header.php"; ?>

<div class="wrapper">
    <div class="box">
        <h2>Lupa Password</h2>
        <p>Masukkan email akun SehatKita</p>

        <?php if(isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <?php if(isset($_GET['sent'])): ?>
            <div class="success">
                Link reset berhasil dibuat!
            </div>

            <script>
                setTimeout(() => {
                    window.location = "reset_password.php?token=<?= $_GET['token'] ?>";
                }, 1800);
            </script>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Masukkan Email" required>
            <button type="submit">Kirim Link Reset</button>
        </form>

        <p style="margin-top:12px;">
            <a href="login.php">← Kembali ke Login</a>
        </p>
    </div>
</div>

<?php include "komponen/footer.php"; ?>

</body>
</html>
