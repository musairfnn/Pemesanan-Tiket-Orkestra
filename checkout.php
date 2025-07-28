<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php?pesan=login_dulu");
  exit;
}


// Daftar konser
$concerts = [
  1 => [
    'judul' => 'Symphony of Twilight',
    'tanggal' => '27 April 2025',
    'waktu' => '19:00',
    'tempat' => 'Gedung Kesenian Jakarta'
  ],
  2 => [
    'judul' => 'In the Misty Moonlight',
    'tanggal' => '7 Mei 2025',
    'waktu' => '19:00',
    'tempat' => 'Teater Besar – TIM'
  ],
  3 => [
    'judul' => 'Echoes of Eternity',
    'tanggal' => '25 Mei 2025',
    'waktu' => '19:00',
    'tempat' => 'Gedung Kesenian Jakarta'
  ]
];

// Dari pilih_bangku.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seat'], $_POST['id_konser'])) {
  $id_konser = (int) $_POST['id_konser'];
  $no_kursi = (int) $_POST['seat'];

  if (!isset($concerts[$id_konser])) {
    die("Konser tidak ditemukan.");
  }

  if ($no_kursi >= 1 && $no_kursi <= 10) {
    $kategori = 'VIP';
    $harga = 1000000;
  } elseif ($no_kursi >= 11 && $no_kursi <= 30) {
    $kategori = 'Eksklusif';
    $harga = 500000;
  } elseif ($no_kursi >= 31 && $no_kursi <= 40) {
    $kategori = 'Premium';
    $harga = 350000;
  } else {
    $kategori = 'Regular';
    $harga = 120000;
  }

  $_SESSION['checkout'] = [
    'id_konser'        => $id_konser,
    'nama_pemesan'     => $_SESSION['nama'] ?? 'Pengguna',
    'nama_konser'      => $concerts[$id_konser]['judul'],
    'tanggal_konser'   => $concerts[$id_konser]['tanggal'],
    'waktu'            => $concerts[$id_konser]['waktu'],
    'tempat'           => $concerts[$id_konser]['tempat'],
    'kategori_tiket'   => $kategori,
    'jumlah_tiket'     => 1,
    'no_kursi'         => $no_kursi,
    'harga_per_tiket'  => $harga,
    'total_bayar'      => $harga
  ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['metode'])) {
  $_SESSION['metode'] = $_POST['metode'];
  header("Location: pembayaran.php");
  exit;
}

$data = $_SESSION['checkout'] ?? null;
if (!$data) {
  header("Location: pilih_bangku.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - ClassiTix</title>
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
      padding-top: 0.6rem;
      padding-bottom: 0.6rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }
    .navbar-brand {
      font-weight: bold;
      color: #f2c94c !important;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.2rem;
    }
    .navbar .btn-sm {
      padding: 0.25rem 0.75rem;
      font-size: 0.875rem;
      font-weight: 500;
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

    .container {
      margin-top: 2rem;
      margin-bottom: 3rem;
    }
    .form-section, .summary-section {
      background-color: #1e1e1e;
      padding: 1.5rem;
      border-radius: 10px;
    }
    .summary-section {
      background-color: #fff;
      color: #000;
    }
    label {
      margin-bottom: 0.5rem;
      font-weight: 500;
    }
    .footer-button {
      display: flex;
      justify-content: space-between;
      margin-top: 1.5rem;
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
      <a href="notifikasi.php" class="icon-btn"><i data-lucide="bell" class="lucide" width="24" height="24"></i></a>
      <a href="keranjang.php" class="icon-btn"><i data-lucide="shopping-cart" class="lucide" width="24" height="24"></i></a>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container">
  <div class="row g-4">
    <!-- Form pembayaran -->
    <div class="col-md-6 form-section">
      <h4 class="mb-4">Metode Pembayaran</h4>
      <form action="checkout.php" method="POST">
        <label for="metode">Pilih Metode</label>
        <select name="metode" id="metode" class="form-select" required>
          <option value="bca">BCA - Virtual Account</option>
          <option value="bni">BNI - Virtual Account</option>
          <option value="mandiri">Mandiri - Virtual Account</option>
        </select>
        <div class="footer-button">
          <a href="pilih_bangku.php?id=<?= $data['id_konser'] ?>" class="btn btn-outline-light">← Kembali</a>
          <button type="submit" class="btn btn-danger w-50">Lanjut Bayar</button>
        </div>
      </form>
    </div>

    <!-- Ringkasan -->
    <div class="col-md-6 summary-section">
      <h5>Ringkasan Pembelian</h5>
      <hr>
      <p><strong>Nama Pemesan:</strong> <?= htmlspecialchars($data['nama_pemesan'] ?? '') ?></p>
      <p><strong>Nama Konser:</strong> <?= htmlspecialchars($data['nama_konser'] ?? '') ?></p>
      <p><strong>Tanggal:</strong> <?= htmlspecialchars($data['tanggal_konser'] ?? '') ?></p>
      <p><strong>Waktu:</strong> <?= htmlspecialchars($data['waktu'] ?? '') ?></p>
      <p><strong>Tempat:</strong> <?= htmlspecialchars($data['tempat'] ?? '') ?></p>
      <p><strong>Kategori Tiket:</strong> <?= htmlspecialchars($data['kategori_tiket'] ?? '') ?></p>
      <p><strong>Jumlah Tiket:</strong> <?= htmlspecialchars($data['jumlah_tiket'] ?? '') ?></p>
      <p><strong>No. Kursi:</strong> <?= htmlspecialchars($data['no_kursi'] ?? '') ?></p>
      <p><strong>Harga per Tiket:</strong> Rp<?= number_format($data['harga_per_tiket'] ?? 0, 0, ',', '.') ?></p>
      <hr>
      <h5><strong>Total Bayar:</strong> Rp<?= number_format($data['total_bayar'] ?? 0, 0, ',', '.') ?></h5>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();
</script>
</body>
</html>
