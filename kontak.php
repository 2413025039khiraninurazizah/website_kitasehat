<?php 
// 1. NYALAKAN SAKLAR TAMU JUGA
$paksa_tamu = true; 

// 2. Panggil Header
include "Komponen/header.php"; 
?>

<section class="kontak-section">
    <div class="kontak-box">
        <h2>Hubungi Kami</h2>
        <p>
            Punya pertanyaan seputar kesehatan atau kendala teknis? 
            Tim SehatKita siap membantu kamu.
        </p>
        
        <div class="kontak-list">
            <p>📧 <strong>Email:</strong> admin@sehatkita.com</p>
            <p>📱 <strong>WhatsApp:</strong> +62 812-3456-7890</p>
            <p>📍 <strong>Alamat:</strong> Jl. Pendidikan No. 1, Lampung</p>
        </div>

        <a href="https://wa.me/6281234567890" class="btn-wa">Chat WhatsApp Sekarang</a>
    </div>
</section>

<?php include "Komponen/footer.php"; ?>