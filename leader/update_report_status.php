<?php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit();
}

// Ambil data JSON dari request
$data = json_decode(file_get_contents('php://input'), true);
$reportId = $data['id'];

// Update status laporan
$sql = "UPDATE leader_reports SET status='completed' WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reportId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update status"]);
}

$stmt->close();
$conn->close();
?>
