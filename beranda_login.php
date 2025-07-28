<?php
session_start();
if (!isset($_SESSION['nama'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ClassiTix - Orkestra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #000;
    }
    .navbar-brand {
      font-weight: bold;
      color: #f2c94c;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .navbar-nav .nav-link {
      color: white;
    }
    .btn-warning, .btn-success {
      color: black;
      font-weight: 500;
    }
    .hero-text {
      position: absolute;
      bottom: 20px;
      left: 30px;
      color: white;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
    }
    .concert-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 5px;
    }
    .concert-date {
      margin-top: 0.5rem;
      font-size: 0.9rem;
      color: #ddd;
    }
    .icon-btn {
      background: none;
      border: none;
      color: white;
      padding: 0;
      position: relative;
    }
    .icon-btn .tooltip-nama {
      display: none;
      position: absolute;
      top: 110%;
      left: 50%;
      transform: translateX(-50%);
      background-color: #222;
      color: #fff;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 0.8rem;
      white-space: nowrap;
      z-index: 10;
    }
    .icon-btn:hover .tooltip-nama {
      display: block;
    }
    footer {
      background-color: #000;
      color: #aaa;
      text-align: center;
      padding: 1rem 0;
      margin-top: 4rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand d-flex align-items-center gap-2" href="beranda_login.php">
      <i data-lucide="ticket" class="lucide" width="24" height="24"></i> <span>ClassiTix</span>
    </a>
    <div class="d-flex align-items-center gap-2">
      <a href="pesan_tiket.php" class="btn btn-warning btn-sm">Pesan Tiket</a>
      <a href="bantuan.php" class="btn btn-warning btn-sm">Bantuan</a>
       <div class="icon-btn">
      <a href="profil.php" style="color: inherit; text-decoration: none;">
        <i data-lucide="user-circle" class="lucide" width="24" height="24"></i>
      </a>
      <?php if (isset($_SESSION['nama'])): ?>
        <div class="tooltip-nama"><?= htmlspecialchars($_SESSION['nama']) ?></div>
      <?php endif; ?>
  </div>

      <a href="notifikasi.php" class="icon-btn" aria-label="Notifikasi">
        <i data-lucide="bell" class="lucide" width="24" height="24"></i>
      </a>
      <a href="keranjang.php" class="icon-btn" aria-label="Keranjang">
        <i data-lucide="shopping-cart" class="lucide" width="24" height="24"></i>
      </a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="position-relative">
  <img src="assets/images/hero.jpg" class="w-100" style="max-height: 500px; object-fit: cover;">
  <div class="hero-text">
    <h1 class="fw-bold">Exclusive Access to<br>World-Class Orchestras</h1>
  </div>
</div>

<!-- Simfoni Section -->
<div class="container mt-5">
  <h4 class="mb-4 border-bottom pb-2">Simfoni yang akan Datang</h4>
  <div class="row g-4">
    <?php
    $concerts = [
      ['img' => 'concert1.jpg', 'date' => '5 April 2025', 'time' => '19.00'],
      ['img' => 'concert2.jpg', 'date' => '20 April 2025', 'time' => '17.00'],
      ['img' => 'concert3.jpg', 'date' => '11 Mei 2025', 'time' => '19.00'],
      ['img' => 'concert4.jpg', 'date' => '25 Mei 2025', 'time' => '19.00'],
    ];
    foreach ($concerts as $c) {
      echo '<div class="col-6 col-md-3 concert-card">
              <img src="assets/images/'.$c['img'].'" class="img-fluid shadow">
              <div class="concert-date">'.$c['date'].'<br>'.$c['time'].'</div>
            </div>';
    }
    ?>
  </div>
  <div class="mt-3">
    <a href="pesan_tiket.php" class="text-info text-decoration-underline">Lihat Jadwal Selengkapnya...</a>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();
  });
</script>

<?php if (isset($_GET['paid']) && $_GET['paid'] == 1): ?>
<script>
  setTimeout(() => {
    alert("🎉 Pembayaran Berhasil!\nTiket Anda sudah dikonfirmasi.");
    window.location.href = "beranda_login.php";
  }, 500);
</script>
<?php endif; ?>

</body>
</html>
