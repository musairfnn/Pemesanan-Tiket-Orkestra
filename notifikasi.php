<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi & Promo - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #000;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .hero-img {
      max-height: 300px;
      width: 100%;
      object-fit: cover;
    }
    .section-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: #ffc107;
      border-bottom: 2px solid #ffc107;
      padding-bottom: 0.3rem;
      margin-bottom: 1.5rem;
    }
    .card-custom {
      background-color: #1c1c1c;
      border: 1px solid #333;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      transition: 0.3s;
    }
    .card-custom:hover {
      background-color: #2b2b2b;
      border-color: #ffc107;
      transform: translateY(-3px);
    }
    .card-custom h5 {
      color: #ffc107;
    }
    .card-custom p {
      color: #ccc;
      margin-bottom: 0.4rem;
    }
    .promo-code {
      background-color: #ffc107;
      color: black;
      padding: 0.2rem 0.6rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: bold;
      cursor: pointer;
    }
    .btn-detail {
      background-color: #ffc107;
      border: none;
      color: black;
      padding: 0.4rem 1.2rem;
      font-weight: 600;
      border-radius: 30px;
      transition: 0.3s;
    }
    .btn-detail:hover {
      background-color: #e0a800;
      color: black;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">
  <div class="container">
    <!-- Logo dan nama brand -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="beranda_login.php">
      <i data-lucide="ticket" class="text-warning"></i>
      <span class="text-warning fw-bold">ClassiTix</span>
    </a>

    <!-- Menu kanan -->
    <div class="d-flex align-items-center gap-2 ms-auto">
      <a href="pesan_tiket.php" class="btn btn-warning btn-sm">Pesan Tiket</a>
      <a href="bantuan.php" class="btn btn-warning btn-sm">Bantuan</a>
      <a href="profil.php" class="text-white"><i data-lucide="user-circle"></i></a>
      <a href="notifikasi.php" class="text-white"><i data-lucide="bell"></i></a>
      <a href="keranjang.php" class="text-white"><i data-lucide="shopping-cart"></i></a>
      
    </div>
  </div>
</nav>


<!-- Hero Image -->
<div class="container-fluid p-0">
  <img src="assets/images/hero.jpg" alt="Konser" class="img-fluid hero-img">
</div>

<!-- Konten Notifikasi -->
<div class="container py-5">
  <h3 class="section-title">🔔 Notifikasi Terbaru</h3>

  <!-- Notifikasi -->
  <div class="card-custom">
    <h5><i data-lucide="music"></i> Symphony of Twilight dimulai 5 hari lagi</h5>
    <p><i data-lucide="map-pin" class="me-1"></i> Lokasi: Gedung Kesenian Jakarta</p>
    <p><i data-lucide="users" class="me-1"></i> Dihadiri oleh Iswardia Sugarno dan Ahmad Dhani Orkestra</p>
    <a href="detail_konser.php?id=1" class="btn btn-detail mt-2">
    <i data-lucide="eye" class="me-1"></i> Lihat Detail
    </a>

  </div>

  <!-- Promo -->
  <h3 class="section-title mt-5">🔥 Promo Penawaran</h3>

  <div class="card-custom">
    <h5><i data-lucide="flame"></i> Promo Lebaran 30% untuk konser In the Misty Moonlight</h5>
    <p><i data-lucide="clock" class="me-1"></i> Berlaku hingga: 30 April 2025</p>
    <p><i data-lucide="tag" class="me-1"></i> Gunakan Kode: 
      <span class="promo-code" onclick="copyKode(this)">IDULFITRI2025</span>
    </p>
    <a href="detail_konser.php?id=2" class="btn btn-detail mt-2">
    <i data-lucide="eye" class="me-1"></i> Lihat Detail
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();

  function copyKode(elem) {
    const kode = elem.textContent;
    navigator.clipboard.writeText(kode).then(() => {
      elem.textContent = 'Copied!';
      elem.style.backgroundColor = '#28a745';
      setTimeout(() => {
        elem.textContent = kode;
        elem.style.backgroundColor = '#ffc107';
      }, 1000);
    });
  }
</script>

<!-- Footer -->
<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

</body>
</html>
