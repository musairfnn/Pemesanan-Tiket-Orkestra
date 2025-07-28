<?php
// Ambil data dari form
$nama     = $_POST['nama'] ?? '';
$telepon  = $_POST['telepon'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - ClassiTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #000;
      color: white;
    }
    .register-box {
      background-color: #444;
      padding: 2rem;
      border-radius: 10px;
      max-width: 500px;
      margin: 2rem auto;
    }
    .form-control {
      background-color: #fff;
      color: #000;
    }
    .form-label {
      color: white;
    }
    .social-icons a {
      color: white;
      margin: 0 15px;
      font-size: 24px;
    }
    .hero-img {
      max-height: 300px;
      object-fit: cover;
      width: 100%;
    }
  </style>
</head>
<body>

<!-- Gambar Hero -->
<div class="container-fluid p-0">
  <img src="assets/images/hero.jpg" class="img-fluid w-100 hero-img" alt="Orkestra">
</div>

<!-- Form Register -->
<div class="register-box text-center">
  <form action="proses_daftar.php" method="POST">
   <div class="mb-3 text-start">
        <label class="form-label"><i data-lucide="user"></i> Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama Anda..." required>
   </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i data-lucide="phone"></i> Nomor Telepon</label>
        <input type="tel" class="form-control" name="telepon" placeholder="Masukkan nomor telepon Anda..." required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i data-lucide="mail"></i> Email</label>
        <input type="email" class="form-control" name="email" placeholder="Masukkan email Anda..." required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i data-lucide="lock"></i> Password</label>
        <input type="password" class="form-control" name="password" placeholder="Masukkan password Anda..." required>
    </div>

    <button type="submit" class="btn btn-warning w-100">Daftar</button>
  </form>

  <!-- Login cepat --> 
   <!-- Maaf Pak yg ini belum saya setting -->
  <p class="mt-3">Daftar lebih cepat dengan</p>
  <div class="social-icons mb-3">
    <a href="#"><i data-lucide="chrome"></i></a>
    <a href="#"><i data-lucide="instagram"></i></a>
    <a href="#"><i data-lucide="x"></i></a>
  </div>

  <div><a href="beranda.php" class="text-white">Kembali</a></div>
  <p class="mt-2">Sudah punya akun? <a href="login.php" class="text-warning">Masuk Di sini!</a></p>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>



<script>
  lucide.createIcons();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
