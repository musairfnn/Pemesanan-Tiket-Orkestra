<?php
session_start();

// Hapus data checkout dari session
unset($_SESSION['checkout']);

// Arahkan kembali ke halaman keranjang
header('Location: keranjang.php');
exit;
