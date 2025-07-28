<?php

$conn = new mysqli("localhost", "root", "", "classitix");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

?>