<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bantuan - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
      background-color: #000 !important;
      padding-top: 0.5rem !important;
      padding-bottom: 0.5rem !important;
    }

    .navbar-brand {
      font-weight: bold;
      color: #f2c94c !important;
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

    .content-container {
      max-width: 800px;
      margin: 3rem auto;
      padding: 2rem;
      background-color: #1e1e1e;
      border-radius: 10px;
    }

    .btn-kotak-masuk {
      background-color: #f2c94c;
      color: black;
      font-weight: bold;
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 5px;
      margin-bottom: 1.5rem;
    }

    .btn-kotak-masuk:hover {
      background-color: #ddb928;
    }

    .divider {
      border-top: 1px solid #888;
      margin: 2rem 0 1.5rem;
    }

    .sosial-icon {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 0.8rem;
    }

    .sosial-icon i {
      width: 20px;
      height: 20px;
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
<nav class="navbar navbar-expand-lg navbar-dark">
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

<!-- Konten Bantuan -->
<div class="container content-container">
  <h1 class="mb-3">Hubungi Kami</h1>
  <p>Punya pertanyaan seputar konser atau pemesanan tiket? Silakan hubungi kami melalui kotak masuk atau kontak di bawah ini.</p>

  <a href="kotak_masuk.php" class="btn btn-warning btn-md fw-bold">Kotak Masuk</a>


  <div class="divider"></div>

  <p><strong>Jam Operasional:</strong><br>Senin – Jumat, 09:00 —17:00</p>
  <p><strong>Alamat:</strong><br>Jl. Soetomo No.29, RT.6/RW.3, Mangga Dua, Kecamatan Cempaka Baru, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10112</p>
  <p><strong>Email:</strong> Classitixorchestra@gmail.com<br>
     <strong>Telepon:</strong> +6287125828121</p>

  <div class="mt-4">
    <div class="sosial-icon"><i data-lucide="instagram"></i> ClassiTiX_</div>
    <div class="sosial-icon"><i data-lucide="facebook"></i> ClassiTiket</div>
    <div class="sosial-icon"><i data-lucide="youtube"></i> ClassiTix Indonesia</div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();
</script>
</body>
</html>
