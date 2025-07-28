<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ClassiTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #000;
      color: white;
    }
    .login-box {
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
    .social-icons i {
      font-size: 24px;
    }
    .social-icons a {
      color: white;
      margin: 0 15px;
    }
    .hero-img {
      max-height: 300px;
      object-fit: cover;
      width: 100%;
    }
  </style>
</head>
<body>

  <!-- Hero Gambar -->
  <div class="container-fluid p-0">
    <img src="assets/images/hero.jpg" class="img-fluid w-100 hero-img" alt="Orkestra">
  </div>

  <!-- ✅ Notifikasi sukses -->
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    alert("Daftar berhasil! Silakan login.");
  </script>
  <?php endif; ?>

  <!-- Login Form -->
  <div class="login-box text-center">
    <form action="login_proses.php" method="POST">
      <div class="mb-3 text-start">
        <label class="form-label"><i data-lucide="mail"></i> Email</label>
        <input type="email" class="form-control" name="email" placeholder="Masukkan Email anda..." required>
      </div>
      <div class="mb-3 text-start">
        <label class="form-label"><i data-lucide="lock"></i> Password</label>
        <input type="password" class="form-control" name="password" placeholder="Masukkan Password anda..." required>
      </div>
      <button type="submit" class="btn btn-warning w-100">Login</button>
    </form>

    <!-- Login cepat -->
    <p class="mt-3">Log in lebih cepat dengan</p>
    <div class="social-icons">
      <a href="#"><i data-lucide="chrome"></i></a>
      <a href="#"><i data-lucide="instagram"></i></a>
      <a href="#"><i data-lucide="x"></i></a>
    </div>

    <div class="mt-3">
      <a href="beranda.php" class="text-white">Kembali</a>
    </div>
    <p class="mt-2">Belum punya akun? <a href="daftar.php" class="text-warning">Daftar Di sini!</a></p>
  </div>

  <footer class="bg-dark text-white text-center mt-5 p-3">
    &copy; 2025 ClassiTix. All rights reserved.
  </footer>

  <script>
    lucide.createIcons();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
