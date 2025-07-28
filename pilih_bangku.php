<?php

include 'koneksi.php';

// Daftar konser
$concerts = [
  1 => [
    'judul' => 'Symphony of Twilight',
    'tanggal' => '27 April 2025',
    'waktu' => '19:00',
    'tempat' => 'Gedung Kesenian Jakarta',
    'kursi' => 64
  ],
  2 => [
    'judul' => 'In the Misty Moonlight',
    'tanggal' => '7 Mei 2025',
    'waktu' => '19:00',
    'tempat' => 'Teater Besar – TIM',
    'kursi' => 90
  ],
  3 => [
    'judul' => 'Echoes of Eternity',
    'tanggal' => '25 Mei 2025',
    'waktu' => '19:00',
    'tempat' => 'Gedung Kesenian Jakarta',
    'kursi' => 100
  ]
];

// Ambil ID konser dari URL
$konser_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!isset($concerts[$konser_id])) {
  die("Konser tidak ditemukan.");
}

$judul_konser = $concerts[$konser_id]['judul'];
$tanggal_konser = $concerts[$konser_id]['tanggal'];
$total_kursi = $concerts[$konser_id]['kursi'];

// Ambil nomor kursi yang sudah dipesan untuk konser ini
$sql = "SELECT no_kursi FROM pemesanan WHERE id_konser = $konser_id";
$result = mysqli_query($conn, $sql);

$bookedSeats = [];
while ($row = mysqli_fetch_assoc($result)) {
  $bookedSeats[] = (int)$row['no_kursi'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Bangku - <?= $judul_konser ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { background-color: #121212; color: white; font-family: 'Segoe UI', sans-serif; }
    .navbar { background-color: #000; }
    .navbar-brand { font-weight: bold; color: #f2c94c; display: flex; align-items: center; gap: 0.5rem; }
    .seat {
      width: 40px; height: 40px; border-radius: 50%; border: none; margin: 5px;
      font-weight: bold; color: white; cursor: pointer; transition: transform 0.2s;
    }
    .seat:hover { transform: scale(1.1); box-shadow: 0 0 5px #fff; }
    .vip { background-color: #e74c3c; }
    .eksklusif { background-color: #9b59b6; }
    .premium { background-color: #e67e22; }
    .regular { background-color: #f1c40f; }
    .unavailable { background-color: #7f8c8d; cursor: not-allowed; }
    .seat.selected { outline: 3px solid white; }
    .seat-layout { background-color: #1e1e1e; padding: 2rem; border-radius: 15px; text-align: center; }
    .legend-box { background-color: #1e1e1e; padding: 1rem; border-radius: 10px; }
    .color-box { display: inline-block; width: 20px; height: 20px; border-radius: 5px; vertical-align: middle; }
    .color-box.vip { background-color: #e74c3c; }
    .color-box.eksklusif { background-color: #9b59b6; }
    .color-box.premium { background-color: #e67e22; }
    .color-box.regular { background-color: #f1c40f; }
    .color-box.unavailable { background-color: #7f8c8d; }
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
      <a href="keranjang.php" class="icon-btn" aria-label="Keranjang"><i data-lucide="shopping-cart" class="lucide"></i></a>
    </div>
  </div>
</nav>


<div class="container my-5">
  <h4>Tata Letak Kursi - <strong><?= $judul_konser ?></strong> <span class="text-muted"> - <?= $tanggal_konser ?></span></h4>
  <p>Klik untuk memilih kursi</p>

  <div class="row">
    <div class="col-md-8">
      <div class="seat-layout">
        <div class="bg-secondary text-white mb-3 py-1 rounded-pill" style="width: 200px; margin: 0 auto;">STAGE</div>
        <?php
        for ($i = 1; $i <= $total_kursi; $i++) {
          $class = 'regular';
          if ($i >= 1 && $i <= 10) $class = 'vip';
          elseif ($i >= 11 && $i <= 30) $class = 'eksklusif';
          elseif ($i >= 31 && $i <= 40) $class = 'premium';
          elseif ($i >= 60) $class = 'unavailable';

          // Kursi sudah dipesan → jadi tidak tersedia
          if (in_array($i, $bookedSeats)) $class = 'unavailable';

          echo "<button class='seat $class' onclick='selectSeat($i, this)' " . ($class == 'unavailable' ? 'disabled' : '') . ">$i</button>";
          if ($i % 10 == 0) echo "<br>";
        }
        ?>
        <div class="text-muted mt-2">Door</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="legend-box">
        <h5>Kategori Tiket</h5>
        <ul class="list-unstyled">
          <li><span class="color-box vip me-2"></span> VIP - Rp1.000.000</li>
          <li><span class="color-box eksklusif me-2"></span> Eksklusif - Rp500.000</li>
          <li><span class="color-box premium me-2"></span> Premium - Rp350.000</li>
          <li><span class="color-box regular me-2"></span> Regular - Rp120.000</li>
          <li><span class="color-box unavailable me-2"></span> Tidak Tersedia</li>
        </ul>

        <form action="keranjang.php" method="POST">
          <input type="hidden" name="seat" id="selectedSeat" value="">
          <input type="hidden" name="id_konser" value="<?= $konser_id ?>">
          <button type="submit" class="btn btn-warning mt-3 w-100">Checkout</button>
        </form>

        <a href="detail_konser.php?id=<?= $konser_id ?>" class="btn btn-outline-light w-100 mt-2">Lihat Detail Konser</a>
        <div class="mt-2" id="selected-seat" style="color: #0ff;"></div>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-white text-center mt-5 p-3">
  &copy; 2025 ClassiTix. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();

  function selectSeat(no, btn) {
    document.querySelectorAll('.seat').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    document.getElementById("selectedSeat").value = no;
    document.getElementById("selected-seat").innerText = `Bangku ${no} dipilih`;
  }
</script>
</body>
</html>
