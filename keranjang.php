<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email'])) {
  echo "<script>
    alert('Silakan login terlebih dahulu sebelum memesan tiket.');
    window.location.href = 'login.php';
  </script>";
  exit;
}
include ("koneksi.php");

// Data konser statis
$concerts = [
  1 => ['judul' => 'Symphony of Twilight', 'gambar' => 'concert1.jpg', 'tanggal' => '27 April 2025', 'waktu' => '19:00', 'tempat' => 'Gedung Kesenian Jakarta'],
  2 => ['judul' => 'In the Misty Moonlight', 'gambar' => 'concert2.jpg', 'tanggal' => '7 Mei 2025', 'waktu' => '19:00', 'tempat' => 'Teater Besar – TIM'],
  3 => ['judul' => 'Echoes of Eternity', 'gambar' => 'concert3.jpg', 'tanggal' => '25 Mei 2025', 'waktu' => '19:00', 'tempat' => 'Gedung Kesenian Jakarta']
];

// Jika data POST dikirim dari pilih_kursi.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seat'], $_POST['id_konser'])) {
  $id_konser = (int) $_POST['id_konser'];
  $no_kursi = (int) $_POST['seat'];

  if (!isset($concerts[$id_konser])) {
    die("Konser tidak valid.");
  }

  // Tentukan kategori & harga
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

  // Simpan ke session
  $_SESSION['checkout'] = [
    'id_konser'        => $id_konser,
    'nama_pemesan'     => $_SESSION['nama'] ?? 'Pengguna',
    'nama_konser'      => $concerts[$id_konser]['judul'],
    'gambar'           => $concerts[$id_konser]['gambar'],
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

$data = $_SESSION['checkout'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Pesanan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #000;
      color: #fff;
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
    .cart-wrapper {
      max-width: 900px;
      margin: 40px auto;
      background: #2c2c2c;
      border-radius: 12px;
      padding: 1rem;
      position: relative;
      display: flex;
      gap: 1rem;
      box-shadow: 0 0 10px rgba(255,255,255,0.1);
    }
    .cart-details {
      flex: 1;
      padding-right: 130px;
    }
    .cart-details h5 {
      color: #f1c40f;
    }
    .cart-details p {
      margin: 0.3rem 0;
    }
    .btn-checkout {
      background-color: #f1c40f;
      color: black;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 6px;
      border: none;
    }
    .checkout-form {
      position: absolute;
      bottom: 15px;
      right: 20px;
    }
    .delete-icon {
      color: #fff;
      font-size: 20px;
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
    }
    .thumbnail {
      width: 200px;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
    }
    @media (max-width: 768px) {
      .cart-wrapper {
        flex-direction: column;
        align-items: flex-start;
      }
      .checkout-form {
        position: static;
        margin-top: 1rem;
      }
      .cart-details {
        padding-right: 0;
      }
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
      <a href="keranjang.php"class="icon-btn" aria-label="Keranjang"><i data-lucide="shopping-cart" class="lucide"></i></a>
    </div>
  </div>
</nav>


  <div class="container">
    <h2 class="my-4">Keranjang Pesanan</h2>

    <?php if (!$data): ?>
      <div class="text-center text-white mt-5">
        <p>Tidak ada tiket dalam keranjang.</p>
      </div>
    <?php else: ?>
      <div class="cart-wrapper">
        <a href="hapus_keranjang.php" class="delete-icon"><i data-lucide="trash-2"></i></a>

        <img src="assets/images/<?= htmlspecialchars($data['gambar']) ?>" alt="<?= htmlspecialchars($data['nama_konser']) ?>" class="thumbnail">
        
        <div class="cart-details">
          <h5><?= htmlspecialchars($data['nama_konser']) ?></h5>
          <p>🎟️ <?= htmlspecialchars($data['kategori_tiket']) ?> - Kursi <?= htmlspecialchars($data['no_kursi']) ?></p>
          <p>📍 <?= htmlspecialchars($data['tempat']) ?></p>
          <p>🗓️ <?= htmlspecialchars($data['tanggal_konser']) ?> - <?= htmlspecialchars($data['waktu']) ?></p>
          <p>💰 Rp<?= number_format($data['harga_per_tiket'], 0, ',', '.') ?></p>
        </div>

        <form action="checkout.php" method="POST" class="checkout-form">
          <input type="hidden" name="seat" value="<?= $data['no_kursi'] ?>">
          <input type="hidden" name="id_konser" value="<?= $data['id_konser'] ?>">
          <button type="submit" class="btn btn-checkout">Checkout</button>
        </form>
      </div>
    <?php endif; ?>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>lucide.createIcons();</script>
</body>
</html>
