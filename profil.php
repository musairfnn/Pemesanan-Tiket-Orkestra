<?php
session_start();
include 'koneksi.php';

// Autentikasi
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit;
}

$email = $_SESSION['email'];
$query_user = "SELECT * FROM users WHERE email = '$email'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);

// Ambil riwayat pemesanan
$id_user = $user['id'];
$query_riwayat = "SELECT * FROM pemesanan WHERE id_user = $id_user ORDER BY tanggal_konser DESC";
$result_riwayat = mysqli_query($conn, $query_riwayat);
$pemesanan = [];
while ($row = mysqli_fetch_assoc($result_riwayat)) {
  $pemesanan[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #0e0e0e;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #000;
    }
    .navbar-brand {
      color: #f2c94c;
      font-weight: bold;
    }
    .profile-header {
      background: url('assets/images/hero.jpg') no-repeat center;
      background-size: cover;
      padding: 3rem 2rem;
      color: white;
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }
    .profile-header img {
      width: 160px;
      height: 160px;
      border-radius: 50%;
      border: 3px solid #ffc107;
      object-fit: cover;
    }
    .info-text h3 {
      font-weight: bold;
      margin-bottom: 0.3rem;
    }
    .edit-section {
      margin-top: 0.5rem;
    }
    .edit-section button {
      background: white;
      color: black;
      font-size: 0.85rem;
      font-weight: 500;
    }
    .riwayat-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 2rem;
      gap: 2rem;
    }
    .left-info {
      width: 100%;
      max-width: 380px;
    }
    .right-riwayat {
      flex-grow: 1;
    }
    .card-riwayat {
      background-color: #d5a100;
      color: black;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1rem;
    }
    .card-riwayat h6 {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .card-riwayat p {
      margin-bottom: 0.3rem;
    }
    .card-riwayat .btn {
      font-size: 0.9rem;
    }
    .footer-btn {
      margin-top: 1.5rem;
    }
    a.text-white:hover {
      color: #ffc107 !important;
    }
    .icon-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0.8rem 0;
    }
    .d-none {
      display: none;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black py-2">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand d-flex align-items-center gap-2" href="beranda_login.php">
      <i data-lucide="ticket"></i> <span>ClassiTix</span>
    </a>
    <div class="d-flex align-items-center gap-2">
      <a href="pesan_tiket.php" class="btn btn-warning btn-sm">Pesan Tiket</a>
      <a href="bantuan.php" class="btn btn-warning btn-sm">Bantuan</a>
      <a href="profil.php" class="btn text-white"><i data-lucide="user-circle"></i></a>
      <a href="notifikasi.php" class="btn text-white"><i data-lucide="bell"></i></a>
      <a href="keranjang.php" class="btn text-white"><i data-lucide="shopping-cart"></i></a>
    </div>
  </div>
</nav>



<!-- Header Profil -->
<div class="profile-header">
  <div class="position-relative">
    <img src="assets/images/default-profile.jpg" alt="Foto Profil">
    <i data-lucide="pencil" class="position-absolute bottom-0 end-0 bg-warning rounded-circle p-1" style="cursor:pointer;"></i>
  </div>
  <div class="info-text">
    <h3><?= htmlspecialchars($user['nama']) ?></h3>
    <p><?= htmlspecialchars($user['email']) ?><br><?= htmlspecialchars($user['no_telp'] ?? '-') ?></p>
    <div class="edit-section d-flex gap-2">
      <a href="edit_info.php" class="btn btn-light btn-sm"><i data-lucide="edit-3" class="me-1"></i> Edit Info</a>
      <button class="btn btn-outline-light btn-sm" onclick="konfirmasiLogout()">Logout</button>
    </div>
  </div>
</div>

<!-- Isi Profil -->
<div class="container riwayat-container">
  <!-- Kiri -->
  <div class="left-info">
    <div class="icon-label">
      <i data-lucide="key-round"></i>
      <a href="ubah_password.php" class="text-white">Ubah Password</a>
    </div>
    <div class="footer-btn">
      <a href="beranda_login.php" class="btn btn-outline-light">Kembali ke Halaman Utama</a>
    </div>
  </div>

  <!-- Kanan -->
  <div class="right-riwayat">
    <h5 class="mb-3">🟡 Riwayat Pemesanan</h5>

    <?php if (count($pemesanan) > 0): ?>
      <?php foreach ($pemesanan as $i => $p): ?>
        <div class="card-riwayat <?= $i >= 2 ? 'd-none riwayat-lain' : '' ?>">
          <h6><?= htmlspecialchars($p['nama_konser']) ?> 
            <?= strtotime($p['tanggal_konser']) < time() ? '✅ Selesai' : '🕒 Akan Datang' ?>
          </h6>
          <p>Tanggal: <?= htmlspecialchars($p['tanggal_konser']) ?></p>
          <p>Kursi: <?= htmlspecialchars($p['kategori_tiket']) ?> - <?= htmlspecialchars($p['no_kursi']) ?></p>
          <a href="detail_tiket.php?id=<?= $p['id'] ?>" class="btn btn-dark">
            <i data-lucide="ticket" class="me-1"></i> Lihat Tiket
          </a>

        </div>
        <?php endforeach; ?>
        <?php if (count($pemesanan) > 2): ?>
          <button class="btn btn-outline-warning btn-sm" onclick="toggleRiwayat()" id="toggleBtn">Lihat Semua</button>
        <?php endif; ?>
      <?php else: ?>
         <p class="text-muted">Belum ada riwayat pemesanan.</p>
      <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();

  function toggleRiwayat() {
    const hiddenItems = document.querySelectorAll('.riwayat-lain');
    const btn = document.getElementById('toggleBtn');
    hiddenItems.forEach(item => item.classList.toggle('d-none'));
    btn.innerText = btn.innerText === 'Lihat Semua' ? 'Sembunyikan' : 'Lihat Semua';
  }


  function konfirmasiLogout() {
    if (confirm("Apakah Anda yakin ingin logout?")) {
      // Pakai AJAX untuk logout tanpa redirect ke logout.php
      fetch('logout.php')
        .then(() => window.location.href = 'beranda.php');
    }
  }


</script>
</body>
</html>
