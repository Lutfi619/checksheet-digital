<?php
session_start();
session_regenerate_id(true); // Buat ID sesi baru untuk menghindari tabrakan sesi

include('../php/db_connection.php');
header('Content-Type: application/json');

$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

$response = [];

if (empty($nik) || empty($password)) {
    $response['success'] = false;
    $response['message'] = 'NIK and Password are required.';
    echo json_encode($response);
    exit();
}

$password = md5($password);

$query = "SELECT * FROM users WHERE nik = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $nik, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Simpan data pengguna ke sesi
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nik' => $user['nik'],
        'role' => $user['role'], // Simpan role pengguna dalam session
    ];

    $response['success'] = true;

    // Redirect berdasarkan role pengguna
    if ($user['role'] === 'supervisor') {
        $response['redirect'] = '../SPV/supervisor_dashboard.php';
    } elseif ($user['role'] === 'leader') {
        $response['redirect'] = '../leader/leader_dashboard.php';
    } else {
        $response['redirect'] = '../dashboard.html'; // Halaman default untuk pengguna biasa
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid NIK or Password.';
}

echo json_encode($response);
?>
