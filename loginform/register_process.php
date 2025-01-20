<?php
include('../php/db_connection.php');
header('Content-Type: application/json');

$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';
$full_name = $_POST['full_name'] ?? ''; // Tambahkan full_name

$response = [];

// Validasi input
if (empty($nik) || empty($password) || empty($full_name)) {
    $response['success'] = false;
    $response['message'] = 'Nama Lengkap, NIK, dan Password wajib diisi.';
    echo json_encode($response);
    exit();
}

// Enkripsi password
$password = md5($password);

// Masukkan data ke tabel users
$query = "INSERT INTO users (full_name, nik, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $full_name, $nik, $password);

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = 'Gagal membuat akun. NIK mungkin sudah digunakan.';
}

echo json_encode($response);
?>
