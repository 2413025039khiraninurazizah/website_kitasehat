document.getElementById("btnHitung").addEventListener("click", function () {
  const berat = parseFloat(document.getElementById("berat").value);
  const tinggi = parseFloat(document.getElementById("tinggi").value) / 100;
  const hasil = document.getElementById("hasil");

  if (isNaN(berat) || isNaN(tinggi)) {
    hasil.textContent = "Masukkan berat dan tinggi yang valid!";
    hasil.classList.add("show");
    return;
  }

  const bmi = berat / (tinggi * tinggi);
  let kategori = "";
  let saran = "";

  if (bmi < 18.5) {
    kategori = "Kurus";
    saran = "Perbanyak asupan gizi dan kalori.";
  } else if (bmi < 25) {
    kategori = "Normal";
    saran = "Pertahankan pola makan dan olahraga teratur.";
  } else if (bmi < 30) {
    kategori = "Gemuk";
    saran = "Mulai kurangi makanan berlemak dan rutin olahraga.";
  } else {
    kategori = "Obesitas";
    saran = "Konsultasikan dengan dokter dan perbaiki pola makan.";
  }

  hasil.textContent = `BMI kamu ${bmi.toFixed(1)} — ${kategori}. ${saran}`;
  hasil.classList.add("show");
});

const searchInput = document.getElementById("searchInput");
const artikelCards = document.querySelectorAll(".artikel-card");

searchInput.addEventListener("keyup", function () {
  const filter = this.value.toLowerCase().trim();

  artikelCards.forEach((card) => {
    const kategori = card.dataset.kategori.toLowerCase();
    const judul = card.querySelector("h3").textContent.toLowerCase();

    if (kategori.includes(filter) || judul.includes(filter) || filter === "") {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
});

document.querySelector('.btn-hero').addEventListener('click', function(e) {
  e.preventDefault();

  const target = document.querySelector('#artikel');
  const headerOffset = 90;
  const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
  const startPosition = window.pageYOffset;
  const distance = targetPosition - startPosition;
  const duration = 1200; 
  let startTime = null;

  function smoothScroll(currentTime) {
    if (startTime === null) startTime = currentTime;
    const elapsed = currentTime - startTime;

    const ease = easeInOutCubic(elapsed, startPosition, distance, duration);
    window.scrollTo(0, ease);

    if (elapsed < duration) requestAnimationFrame(smoothScroll);
  }

  function easeInOutCubic(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return (c / 2) * t * t * t + b;
    t -= 2;
    return (c / 2) * (t * t * t + 2) + b;
  }

  requestAnimationFrame(smoothScroll);
});