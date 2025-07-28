<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "classitix");

if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Tangkap data dari form
$nama     = $_POST['nama'];
$no_telp  = $_POST['no_telp'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi

session_start();
// setelah cek data user cocok:
$_SESSION['nama'] = $nama_user_dari_database;


// Cek apakah email sudah terdaftar
$cek = $koneksi->query("SELECT * FROM users WHERE email = '$email'");
if ($cek->num_rows > 0) {
  echo "<script>alert('Email sudah terdaftar!'); window.location='daftar.php';</script>";
  exit;
}


$sql = "INSERT INTO users (nama, no_telp, email, password) 
        VALUES ('$nama', '$no_telp', '$email', '$password')";

// Eksekusi query
if ($koneksi->query($sql) === TRUE) {
  header("Location: login.php?success=1");
  exit;
} else {
  echo "Gagal daftar: " . $koneksi->error;
}

$koneksi->close();
?>
