document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();

  if (username === "" || password === "") {
    alert("Isi semua kolom terlebih dahulu!");
    return;
  }

  if (username === "admin" && password === "admin123") {
    alert("Login berhasil sebagai ADMIN!");
    window.location.href = "admin.html"; // nanti diarahkan ke halaman admin
  } else {
    alert("Login berhasil sebagai PENGGUNA!");
    window.location.href = "index.html";
  }
});