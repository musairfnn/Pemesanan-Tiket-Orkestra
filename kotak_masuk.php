<?php
session_start();
include 'koneksi.php';

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_lengkap']);
    $email = trim($_POST['email']);
    $pesan = trim($_POST['pesan']);

    if ($nama && $email && $pesan) {
        $stmt = $conn->prepare("INSERT INTO kotak_masuk (nama_lengkap, email, pesan) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $pesan);
        if ($stmt->execute()) {
            $success = true;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kotak Masuk - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background: url('assets/images/hero.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      color: white;
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
    .kotak-form {
      background-color: rgba(0, 0, 0, 0.75);
      padding: 2rem;
      border-radius: 10px;
      margin-top: 3rem;
      margin-bottom: 4rem;
      max-width: 600px;
    }
    label {
      margin-top: 1rem;
      font-weight: 500;
    }
    .form-control, textarea {
      background-color: #1f1f1f;
      color: white;
      border: 1px solid #444;
    }
    .form-control:focus, textarea:focus {
      border-color: #f2c94c;
      box-shadow: none;
    }
    .btn-kirim {
      background-color: #f2c94c;
      color: black;
      font-weight: bold;
      margin-top: 1.5rem;
    }
    .btn-kembali {
      position: fixed;
      bottom: 20px;
      left: 20px;
      color: #ccc;
      font-size: 0.9rem;
      text-decoration: none;
    }
    .btn-kembali:hover {
      text-decoration: underline;
    }
    footer {
      background-color: #000;
      color: #aaa;
      text-align: center;
      padding: 1rem 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= isset($_SESSION['nama']) ? 'beranda_login.php' : 'beranda.php' ?>">
      <i data-lucide="ticket" class="lucide" width="24" height="24"></i> <span>ClassiTix</span>
    </a>
    <div class="d-flex align-items-center gap-2">
      <a href="pesan_tiket.php" class="btn btn-warning btn-sm">Pesan Tiket</a>
      <a href="bantuan.php" class="btn btn-warning btn-sm">Bantuan</a>
      <div class="icon-btn">
        <i data-lucide="user-circle" class="lucide" width="24" height="24"></i>
        <?php if (isset($_SESSION['nama'])): ?>
          <div class="tooltip-nama"><?= htmlspecialchars($_SESSION['nama']) ?></div>
        <?php endif; ?>
      </div>
      <a href="notifikasi.php" class="icon-btn"><i data-lucide="bell" class="lucide"></i></a>
      <a href="keranjang.php" class="icon-btn"><i data-lucide="shopping-cart" class="lucide"></i></a>
    </div>
  </div>
</nav>

<!-- Form -->
<div class="container d-flex justify-content-center">
  <div class="kotak-form w-100">
    <h3>Kotak Masuk</h3>
    <p class="mb-4">Silakan isi formulir berikut untuk menyampaikan pesan atau pertanyaan Anda.</p>

    <?php if ($success): ?>
      <div class="alert alert-success">Pesan berhasil dikirim. Terima kasih!</div>
    <?php endif; ?>

    <form method="POST">
      <label for="nama_lengkap">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" class="form-control" required>

      <label for="email">Email</label>
      <input type="email" name="email" class="form-control" required>

      <label for="pesan">Pesan</label>
      <textarea name="pesan" rows="5" class="form-control" required></textarea>

      <button type="submit" class="btn btn-kirim w-100">Kirim</button>
    </form>
  </div>
</div>

<!-- Kembali -->
<a href="<?= isset($_SESSION['nama']) ? 'beranda_login.php' : 'beranda.php' ?>" class="btn-kembali">← Kembali ke halaman utama</a>

<!-- Footer -->
<footer class="text-white text-center mt-5">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>
