<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'] ?? 1;

// Data konser statis
$konser = [
  1 => [
    'judul' => 'Symphony of Twilight',
    'deskripsi' => 'Sebuah perjalanan musikal yang mengiringi senja menuju malam penuh keajaiban.',
    'image' => 'concert1.jpg',
    'tanggal' => '27 April 2025, 19:00',
    'lokasi' => 'Gedung Kesenian Jakarta',
    'harga' => [
      'Regular' => 'Rp120.000',
      'Premium' => 'Rp350.000',
      'Eksklusif' => 'Rp600.000',
      'VIP' => 'Rp1.000.000'
    ],
    'kapasitas' => 64,
    'pengisi' => [
      'Konduktor' => 'Iswarjita R. Sudarmo',
      'Orkestra' => 'Ahmad Dhani Philharmonic',
      'Bintang Tamu' => 'Ahmad Dhani'
    ]
  ],
  2 => [
    'judul' => 'In the Misty Moonlight',
    'deskripsi' => 'Konser bertema cinta dan emosi yang dalam dari karya Schubert dan Brahms.',
    'image' => 'concert2.jpg',
    'tanggal' => '4 Mei 2025, 18:00',
    'lokasi' => 'Balai Sarbini, Jakarta',
    'harga' => [
      'Regular' => 'Rp100.000',
      'Premium' => 'Rp300.000',
      'Eksklusif' => 'Rp500.000',
      'VIP' => 'Rp900.000'
    ],
    'kapasitas' => 90,
    'pengisi' => [
      'Konduktor' => 'Rico Wibowo',
      'Orkestra' => 'Jakarta String Ensemble',
      'Bintang Tamu' => 'Raisa'
    ]
  ],
  3 => [
    'judul' => 'Echoes of Eternity',
    'deskripsi' => 'Menampilkan karya legendaris Beethoven, Mozart, dan Bach dalam kemasan modern.',
    'image' => 'concert3.jpg',
    'tanggal' => '18 Mei 2025, 20:00',
    'lokasi' => 'Teater Jakarta, TIM',
    'harga' => [
      'Regular' => 'Rp150.000',
      'Premium' => 'Rp400.000',
      'Eksklusif' => 'Rp650.000',
      'VIP' => 'Rp1.200.000'
    ],
    'kapasitas' => 60,
    'pengisi' => [
      'Konduktor' => 'Anita Susanto',
      'Orkestra' => 'Indonesia Youth Philharmonic',
      'Bintang Tamu' => 'Idris Sardi Jr.'
    ]
  ]
];

$data = $konser[$id] ?? null;

if (!$data) {
  echo "Konser tidak ditemukan.";
  exit;
}

// Hitung bangku yang sudah dipesan dari database
$kapasitas = $data['kapasitas'];
$tersisa = $kapasitas;

$stmt = $conn->prepare("SELECT COUNT(*) AS jumlah FROM pemesanan WHERE id_konser = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$terisi = (int)$row['jumlah'];
$tersisa = $kapasitas - $terisi;
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Konser - ClassiTix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar { background-color: #000; }
    .navbar-brand {
      font-weight: bold;
      color: #f2c94c;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .icon-btn {
      background: none; border: none; color: white; padding: 0; position: relative;
    }
    .icon-btn .tooltip-nama {
      display: none; position: absolute; top: 110%; left: 50%;
      transform: translateX(-50%); background-color: #222;
      color: #fff; padding: 5px 10px; border-radius: 4px;
      font-size: 0.8rem; white-space: nowrap; z-index: 10;
    }
    .icon-btn:hover .tooltip-nama { display: block; }

    .concert-detail { margin-top: 2rem; }
    .info-box {
      background-color: #1e1e1e;
      border-radius: 10px;
      padding: 1rem;
      color: #ccc;
    }
    .info-box i { margin-right: 5px; }
    .btn-warning { font-weight: bold; }
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
<nav class="navbar navbar-expand-lg navbar-dark py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand d-flex align-items-center gap-2" href="beranda_login.php">
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
      <a href="notifikasi.php" class="icon-btn" aria-label="Notifikasi"><i data-lucide="bell" class="lucide"></i></a>
      <a href="keranjang.php" class="icon-btn" aria-label="Keranjang"><i data-lucide="shopping-cart" class="lucide"></i></a>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container concert-detail">
  <h2><?= $data['judul'] ?></h2>
  <p class="mb-4"><?= $data['deskripsi'] ?></p>

  <div class="row">
    <div class="col-md-6">
      <img src="assets/images/<?= $data['image'] ?>" alt="Concert" class="img-fluid rounded mb-3">
      <a href="pilih_bangku.php?id=<?= $id ?>" class="btn btn-warning me-2"><i data-lucide="ticket"></i> Pesan</a>
      <a href="pesan_tiket.php" class="btn btn-secondary">Kembali ke jadwal</a>
    </div>
    <div class="col-md-6">
      <div class="info-box mb-3">
        <p><i data-lucide="map-pin"></i> <?= $data['lokasi'] ?></p>
        <p><i data-lucide="calendar"></i> <?= $data['tanggal'] ?></p>
        <p><i data-lucide="wallet"></i>
          <?php foreach ($data['harga'] as $kelas => $harga): ?>
            <br><?= $kelas ?>: <?= $harga ?>
          <?php endforeach; ?>
        </p>
        <p><i data-lucide="ticket"></i> <?= $tersisa ?> dari <?= $kapasitas ?> bangku tersedia</p>
      </div>
      <div>
        <h5>Pengisi Acara</h5>
        <ul>
          <?php foreach ($data['pengisi'] as $peran => $orang): ?>
            <li><?= $peran ?>: <?= $orang ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script> lucide.createIcons(); </script>
</body>
</html>
