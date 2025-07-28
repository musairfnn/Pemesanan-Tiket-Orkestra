<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo "<script>
    alert('Silakan login terlebih dahulu sebelum memesan tiket.');
    window.location.href = 'login.php';
  </script>";
  exit;
}



// ✅ Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "classitix");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// ✅ Ambil data dari session
$data = $_SESSION['checkout'] ?? null;
$metode = $_SESSION['metode'] ?? null;
$id_user = $_SESSION['id_user'] ?? null;

if (!$data || !$metode || !$id_user) {
    header("Location: checkout.php");
    exit;
}

// ✅ Format tanggal untuk disimpan (format: Y-m-d)
$tanggal_db = date('Y-m-d', strtotime($data['tanggal_konser']));

// ✅ Simpan ke database
$stmt = $koneksi->prepare("
    INSERT INTO pemesanan (
        id_user, nama_pemesan, nama_konser, tanggal_konser, waktu, tempat,
        kategori_tiket, jumlah_tiket, no_kursi, harga_per_tiket, total_bayar, metode_pembayaran
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssssiiiss",
    $id_user,
    $data['nama_pemesan'],
    $data['nama_konser'],
    $tanggal_db,
    $data['waktu'],
    $data['tempat'],
    $data['kategori_tiket'],
    $data['jumlah_tiket'],
    $data['no_kursi'],
    $data['harga_per_tiket'],
    $data['total_bayar'],
    $metode
);

$stmt->execute();
$stmt->close();
$koneksi->close();

// ✅ Generate nomor VA
$va_number = implode(' ', array_map(fn() => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT), range(1, 4)));

$nama_bank = match ($metode) {
    'bni' => 'Bank BNI',
    'mandiri' => 'Bank Mandiri',
    default => 'Bank BCA'
};

// ✅ Generate batas waktu pembayaran (misal +1 hari jam 23:59)
$batas_bayar = date('l, d F Y', strtotime('+1 day')) . ' - 23:59';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { background-color: #121212; color: white; font-family: 'Segoe UI', sans-serif; }
    .content-box { background-color: #1e1e1e; padding: 2rem; border-radius: 10px; max-width: 900px; margin: 2rem auto; }
    .va-box { background-color: #2a2a2a; padding: 1rem 1.5rem; border-radius: 10px; margin: 1.5rem 0; }
    .va-number { font-size: 1.6rem; color: #f2c94c; font-weight: bold; letter-spacing: 2px; }
    .salin-btn { font-size: 0.9rem; color: white; text-decoration: underline; cursor: pointer; }
    .highlight { color: #ff4d4d; font-weight: 600; }
    footer { background-color: #000; color: #aaa; text-align: center; padding: 1rem 0; margin-top: 4rem; }
  </style>
</head>
<body>

<div class="content-box">
  <h4 class="mb-3">Pembayaran</h4>
  <p><strong>Tiket:</strong> <?= htmlspecialchars($data['kategori_tiket']) ?> - No. Kursi <?= htmlspecialchars($data['no_kursi']) ?>, <em><?= htmlspecialchars($data['nama_konser']) ?></em></p>
  <p><strong>Batas Pembayaran:</strong> <span class="highlight"><?= $batas_bayar ?></span></p>
  <p><strong>Total Pembayaran:</strong> <b>Rp<?= number_format($data['total_bayar'], 0, ',', '.') ?></b></p>

  <div class="va-box">
    <div class="d-flex justify-content-between">
      <span><i data-lucide="banknote" class="me-2"></i> <?= $nama_bank ?></span>
      <span class="salin-btn" onclick="salinNomor()">SALIN</span>
    </div>
    <div class="va-number" id="va-number"><?= $va_number ?></div>
  </div>

  <div class="instructions">
    <h6><i data-lucide="info" class="me-2"></i> Cara Pembayaran via M-<?= strtoupper($metode) ?></h6>
    <ol>
      <li>Buka aplikasi mobile banking</li>
      <li>Pilih menu transfer ke Virtual Account</li>
      <li>Masukkan VA: <?= $va_number ?></li>
      <li>Konfirmasi & lakukan pembayaran</li>
    </ol>
  </div>

  <div class="mt-4 text-end">
    <a href="beranda_login.php" class="btn btn-outline-warning">← Kembali ke Beranda</a>
  </div>
</div>

<footer>&copy; 2025 ClassiTix. All rights reserved.</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();
  function salinNomor() {
    const va = document.getElementById("va-number").innerText;
    navigator.clipboard.writeText(va);
    alert("Nomor VA disalin!");
  }

  setTimeout(() => {
    alert("✅ Pembayaran Berhasil\nData Anda telah disimpan.");
    window.location.href = "beranda_login.php";
  }, 3000);
</script>
</body>
</html>

<?php
// ✅ Bersihkan session agar tidak dobel saat reload
unset($_SESSION['checkout']);
unset($_SESSION['metode']);
?>
