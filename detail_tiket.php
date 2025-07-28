<?php
include 'koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    die("ID pemesanan tidak ditemukan.");
}

$id_pemesanan = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT 
        p.*, 
        u.nama AS nama_user, 
        u.email, 
        u.no_telp 
    FROM pemesanan p
    JOIN users u ON p.id_user = u.id
    WHERE p.id = '$id_pemesanan'
");

if (!$query || mysqli_num_rows($query) === 0) {
    die("Data tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);

$qr_content = "PESANAN-" . $data['id'];
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qr_content);

$tanggal_konser = $data['tanggal_konser'];
$tanggal_valid = ($tanggal_konser && $tanggal_konser !== '0000-00-00' && $tanggal_konser !== '1970-01-01');
$format_tanggal = $tanggal_valid
    ? strftime('%A, %d %B %Y', strtotime($tanggal_konser)) . ' — ' . date('H.i', strtotime($data['waktu'])) . ' WIB'
    : 'Tanggal tidak valid';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tiket Saya - <?= htmlspecialchars($data['nama_konser']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .ticket-wrapper {
      max-width: 900px;
      margin: 40px auto;
      background: #2c2c2c;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 0 15px rgba(255,255,255,0.05);
      position: relative;
    }
    .ticket-header {
      background: url('assets/images/hero.jpg') no-repeat center;
      background-size: cover;
      padding: 2rem;
      border-radius: 10px 10px 0 0;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .ticket-header h1 {
      font-size: 2rem;
      font-weight: bold;
    }
    .ticket-body {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      background: #1c1c1c;
      padding: 2rem;
      border-radius: 0 0 10px 10px;
    }
    .ticket-info {
      flex: 1;
      min-width: 250px;
    }
    .ticket-info p {
      margin: 0.5rem 0;
    }
    .ticket-info span.label {
      font-weight: 600;
    }
    .qr-container {
      text-align: center;
    }
    .qr-container img {
      border: 3px solid #fff;
      padding: 4px;
      background: #fff;
      border-radius: 8px;
    }
    .qr-note {
      margin-top: 0.5rem;
      font-size: 0.85rem;
      color: #ccc;
    }
    .btn-unduh {
      background-color: #f1c40f;
      color: black;
      font-weight: bold;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      margin-top: 1rem;
    }
    .btn-kembali {
      background-color: #fff;
      color: black;
      font-weight: bold;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      position: absolute;
      bottom: 20px;
      left: 20px;
    }
    @media print {
      .btn-kembali, .btn-unduh, .navbar {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
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
      <button class="icon-btn" aria-label="Notifikasi"><i data-lucide="bell" class="lucide"></i></button>
      <button class="icon-btn" aria-label="Keranjang"><i data-lucide="shopping-cart" class="lucide"></i></button>
    </div>
  </div>
</nav>

<!--  KONTEN TIKET -->
<div class="ticket-wrapper">
  <div class="ticket-header">
    <h1>🎫 Tiket Saya</h1>
  </div>
  <div class="ticket-body">
    <div class="ticket-info">
      <h3><?= htmlspecialchars($data['nama_konser']) ?></h3>
      <hr style="border-color: #fff;">
      <p><span class="label">Nama</span> : <?= htmlspecialchars($data['nama_user']) ?></p>
      <p><span class="label">Email</span> : <?= htmlspecialchars($data['email']) ?></p>
      <p><span class="label">Lokasi</span> : <?= htmlspecialchars($data['tempat']) ?></p>
      <p><span class="label">Tanggal</span> : <?= $format_tanggal ?></p>
      <p><span class="label">Kursi</span> : <?= htmlspecialchars($data['kategori_tiket']) ?> - <?= htmlspecialchars($data['no_kursi']) ?></p>
      <p><span class="label">Kode Tiket</span> : TWLT-<?= $data['id'] ?>-<?= $tanggal_valid ? date('dmy', strtotime($data['tanggal_konser'])) : '000000' ?></p>
      <p><span class="label">Metode Pembayaran</span> : <?= htmlspecialchars($data['metode_pembayaran']) ?></p>
      <p><span class="label">Status</span> : Selesai ✅</p>
    </div>
    <div class="qr-container">
      <p class="fw-semibold">QR Code:</p>
      <img src="<?= $qr_url ?>" alt="QR Code">
      <p class="qr-note">QR ini wajib ditunjukkan saat memasuki venue</p>
      <button onclick="window.print()" class="btn btn-unduh">🖨 Unduh Tiket</button>
    </div>
  </div>
  <a href="profil.php" class="btn btn-kembali">← Kembali</a>
</div>

<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>
