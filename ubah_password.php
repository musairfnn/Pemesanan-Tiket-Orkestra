<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit;
}

$email = $_SESSION['email'];
$pesan = "";

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $lama  = $_POST['password_lama'] ?? '';
  $baru  = $_POST['password_baru'] ?? '';
  $konfirmasi = $_POST['konfirmasi_password'] ?? '';

  $query = "SELECT password FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);

if (!password_verify($lama, $user['password'])) {
  $pesan = "❌ Password lama salah!";
} elseif ($baru !== $konfirmasi) {
  $pesan = "❌ Konfirmasi password tidak cocok!";
} else {
  $hashed = password_hash($baru, PASSWORD_DEFAULT); // Hash password baru
  $update = "UPDATE users SET password = '$hashed' WHERE email = '$email'";
  mysqli_query($conn, $update);
  $pesan = "✅ Password berhasil diubah!";
}
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ubah Password - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #000;
      color: white;
    }
    .ubah-box {
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
    .hero-img {
      max-height: 300px;
      object-fit: cover;
      width: 100%;
    }
    .message-box {
      text-align: center;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

<!-- Hero Image -->
<div class="container-fluid p-0">
  <img src="assets/images/hero.jpg" class="img-fluid w-100 hero-img" alt="Orkestra">
</div>

<!-- Ubah Password Form -->
<div class="ubah-box text-center">
  <h4 class="mb-3">🔐 Ubah Password</h4>

  <?php if ($pesan): ?>
    <div class="alert alert-warning py-2"><?= htmlspecialchars($pesan) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3 text-start">
      <label class="form-label"><i data-lucide="key"></i> Password Lama</label>
      <input type="password" name="password_lama" class="form-control" required>
    </div>
    <div class="mb-3 text-start">
      <label class="form-label"><i data-lucide="lock"></i> Password Baru</label>
      <input type="password" name="password_baru" class="form-control" required>
    </div>
    <div class="mb-3 text-start">
      <label class="form-label"><i data-lucide="lock"></i> Konfirmasi Password</label>
      <input type="password" name="konfirmasi_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-warning w-100">Simpan Perubahan</button>
  </form>

  <div class="mt-3">
    <a href="profil.php" class="text-white text-decoration-none">← Kembali ke Profil</a>
  </div>
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
