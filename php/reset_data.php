<?php
// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, kirim pesan error dalam format JSON
    echo json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Ambil nama tabel dari parameter URL
$table = isset($_GET['table']) ? $_GET['table'] : 'idh25d';

// Cek jumlah data dalam tabel
$sql_count = "SELECT COUNT(*) AS total FROM $table";
$result = $conn->query($sql_count);
$row = $result->fetch_assoc();
$total_records = $row['total'];

if ($total_records < 25) {
    // Jika data kurang dari 25, kirim pesan dalam format JSON
    echo json_encode(['status' => 'error', 'message' => "Data harus mencapai batas maksimal jika ingin melakukan reset"]);
    $conn->close();
    exit;
}

// Hapus semua data dari tabel
$sql = "DELETE FROM $table";

if ($conn->query($sql) === TRUE) {
    // Jika berhasil, kirim pesan sukses dalam format JSON
    echo json_encode(['status' => 'success', 'message' => "Data telah berhasil di-reset."]);
} else {
    // Jika gagal, kirim pesan error dalam format JSON
    echo json_encode(['status' => 'error', 'message' => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
