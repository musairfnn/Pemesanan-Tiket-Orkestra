<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "classitix");

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = '$email'";
$result = $koneksi->query($query);

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  if (password_verify($password, $user['password'])) {
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['id_user'] = $user['id']; // ini penting

    header("Location: beranda_login.php");
    exit;
  } else {
    echo "<script>alert('Password salah!'); window.location='login.php';</script>";
  }
} else {
  echo "<script>alert('Email tidak ditemukan!'); window.location='login.php';</script>";
}

$koneksi->close();

$_SESSION['id_user'] = $user['id'];

?>
