<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_konser = $_POST['id_konser'];
    $no_kursi = $_POST['seat'];

    // Ambil info konser dari database
    $result = mysqli_query($conn, "SELECT * FROM konser WHERE id = $id_konser");
    $konser = mysqli_fetch_assoc($result);

    if (!$konser) {
        die("Konser tidak ditemukan.");
    }

    // Tentukan kategori dan harga dari nomor kursi
    $kategori = "Regular";
    $harga = 120000;
    if ($no_kursi >= 1 && $no_kursi <= 10) {
        $kategori = "VIP";
        $harga = 1000000;
    } elseif ($no_kursi >= 11 && $no_kursi <= 30) {
        $kategori = "Eksklusif";
        $harga = 500000;
    } elseif ($no_kursi >= 31 && $no_kursi <= 40) {
        $kategori = "Premium";
        $harga = 350000;
    }

    $_SESSION['keranjang'] = [
        'id_konser' => $id_konser,
        'judul_konser' => $konser['nama'],
        'kursi' => $no_kursi,
        'kategori' => $kategori,
        'harga' => $harga
    ];

    header("Location: keranjang.php");
    exit;
}
?>
