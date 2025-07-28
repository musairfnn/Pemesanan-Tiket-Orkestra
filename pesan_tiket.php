<?php
session_start();


// Data konser
$concerts = [
  1 => [
    'judul' => 'Symphony of Twilight',
    'lokasi' => 'Gedung Kesenian Jakarta',
    'gambar' => 'concert1.jpg',
    'kursi' => 64,
    'tanggal' => '27 April 2025, 19:00'
  ],
  2 => [
    'judul' => 'In the Misty Moonlight',
    'lokasi' => 'Gedung Teater Besar – Taman Ismail Marzuki (TIM)',
    'gambar' => 'concert2.jpg',
    'kursi' => 90,
    'tanggal' => '7 Mei 2025, 19:00'
  ],
  3 => [
    'judul' => 'Echoes of Eternity',
    'lokasi' => 'Gedung Kesenian Jakarta',
    'gambar' => 'concert3.jpg',
    'kursi' => 100,
    'tanggal' => '25 Mei 2025, 19:00'
  ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesan Tiket - ClassiTix</title>
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
    .navbar-nav .nav-link, .icon-btn {
      color: white;
    }
    .btn-warning, .btn-success {
      color: black;
      font-weight: 500;
    }
    .concert-list {
      margin-top: 2rem;
    }
    .concert-item {
      background-color: #1e1e1e;
      border-radius: 10px;
      padding: 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      border-bottom: 1px solid #333;
      flex-wrap: wrap;
    }
    .concert-info h5 {
      margin-bottom: 0.3rem;
      font-weight: bold;
    }
    .concert-info p {
      margin: 0;
      font-size: 0.9rem;
      color: #ccc;
    }
    .concert-date {
      text-align: right;
      font-size: 0.95rem;
      font-weight: 500;
      white-space: nowrap;
    }
    .concert-thumbnail {
      width: 160px;
      height: 100px;
      object-fit: cover;
      border-radius: 5px;
    }
    footer {
      background-color: #000;
      color: #aaa;
      text-align: center;
      padding: 1rem 0;
      margin-top: 4rem;
    }

    .navbar-brand {
  font-weight: bold;
  color: #f2c94c;
  display: flex;
  align-items: center;
  gap: 0.5rem;
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

  </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark py-3">
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
      <a href="notifikasi.php" class="icon-btn" aria-label="Notifikasi"><i data-lucide="bell" class="lucide"></i></a>
      <a href="keranjang.php" class="icon-btn" aria-label="Keranjang"><i data-lucide="shopping-cart" class="lucide"></i></a>
    </div>
  </div>
</nav>

<!-- Judul Halaman -->
<div class="container">
  <h3 class="mt-4">Temukan Konser Favoritmu di Sini</h3>

  <div class="concert-list">
    <?php foreach ($concerts as $id => $c): ?>
      <div class="concert-item">
        <img src="assets/images/<?= $c['gambar'] ?>" alt="Concert <?= $id ?>" class="concert-thumbnail">
        <div class="concert-info flex-grow-1">
          <h5><?= $c['judul'] ?></h5>
          <p><?= $c['lokasi'] ?><br><?= $c['kursi'] ?> Kursi Tersedia</p>
        </div>
        <div class="concert-date">
          <?= $c['tanggal'] ?>
          <div class="mt-2">
            <a href="detail_konser.php?id=<?= $id ?>" class="btn btn-warning btn-sm me-1">Lihat Detail</a>
            <a href="pilih_bangku.php?id=<?= $id ?>" class="btn btn-warning btn-sm">
              <i data-lucide="ticket"></i> Pesan
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();
</script>
</body>
</html>
