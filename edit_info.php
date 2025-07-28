<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit;
}

$email = $_SESSION['email'];

// Ambil data user
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Simpan data jika form disubmit
$pesan = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nama_baru = $_POST['nama'] ?? '';
  $email_baru = $_POST['email'] ?? '';
  $telepon_baru = $_POST['telepon'] ?? '';

  $update = "UPDATE users SET nama = '$nama_baru', email = '$email_baru', no_telp = '$telepon_baru' WHERE email = '$email'";
  if (mysqli_query($conn, $update)) {
    $_SESSION['email'] = $email_baru; // Update session jika email diubah
    $pesan = "✅ Profil berhasil diperbarui!";
    // Refresh data user
    $email = $email_baru;
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
  } else {
    $pesan = "❌ Gagal memperbarui profil!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil - ClassiTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #000;
      color: white;
    }
    .edit-box {
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
  </style>
</head>
<body>

<!-- Hero -->
<div class="container-fluid p-0">
  <img src="assets/images/hero.jpg" class="img-fluid w-100 hero-img" alt="Orkestra">
</div>

<!-- Form Edit Profil -->
<div class="edit-box text-center">
  <h5 class="mb-3">Edit Profil Anda</h5>

  <?php if ($pesan): ?>
    <div class="alert alert-warning"><?= $pesan ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3 text-start">
      <label class="form-label"><i data-lucide="user"></i> Nama Lengkap</label>
      <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($user['nama']) ?>" required>
    </div>

    <div class="mb-3 text-start">
      <label class="form-label"><i data-lucide="mail"></i> Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="mb-3 text-start">
      <label class="form-label"><i data-lucide="phone"></i> Nomor Telepon</label>
      <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($user['no_telp']) ?>" required>
    </div>

    <button type="submit" class="btn btn-warning w-100">Simpan Perubahan</button>
  </form>

  <div class="mt-3">
    <a href="profil.php" class="text-white">← Kembali ke Profil</a>
  </div>
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
