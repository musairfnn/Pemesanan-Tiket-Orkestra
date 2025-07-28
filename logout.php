<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
session_unset();
session_destroy();

// Kirim respons agar fetch() berhasil
http_response_code(200);
header('Content-Type: application/json');
echo json_encode(["message" => "Logout berhasil"]);
exit;
