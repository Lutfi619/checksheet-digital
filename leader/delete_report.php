<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID laporan
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
    // Hapus laporan berdasarkan ID
    $sql = "DELETE FROM leader_reports WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid ID"]);
}

$conn->close();
?>
