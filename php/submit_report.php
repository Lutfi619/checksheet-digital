<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Koneksi ke database gagal."]);
    exit;
}

// Ambil data dari form
$report_date = $_POST['report_date'];
$report_line = $_POST['report_line'];
$report_part = $_POST['report_part'];
$report_desc = $_POST['report_desc'];

// Query untuk menyimpan data
$sql = "INSERT INTO leader_reports (report_date, report_line, report_part, report_desc) VALUES ('$report_date', '$report_line', '$report_part', '$report_desc')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Laporan berhasil dikirim!"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Gagal mengirim laporan. Silakan coba lagi."]);
}

$conn->close();
?>
