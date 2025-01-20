<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hitung jumlah laporan
$sql = "SELECT COUNT(*) AS count FROM leader_reports WHERE status='pending'";
$result = $conn->query($sql);
$count = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
}

$conn->close();

// Kirim data sebagai JSON
header('Content-Type: application/json');
echo json_encode(['count' => $count]);
?>
