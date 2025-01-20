<?php
// Sesuaikan dengan koneksi database Anda
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil nama tabel dari parameter GET
$table = isset($_GET['table']) ? $conn->real_escape_string($_GET['table']) : 'idh25a';

// Query untuk mengambil data dari tabel yang ditentukan
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);

header('Content-Type: application/json');

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'date' => isset($row['date']) ? $row['date'] : null,
            'hatsumono1' => isset($row['hatsumono1']) ? $row['hatsumono1'] : null,
            'hatsumono2' => isset($row['hatsumono2']) ? $row['hatsumono2'] : null,
            'average' => isset($row['average']) ? $row['average'] : null,
            'min_value' => isset($row['min_value']) ? $row['min_value'] : null,
            'max_value' => isset($row['max_value']) ? $row['max_value'] : null,
            'range_value' => isset($row['range_value']) ? $row['range_value'] : null,
            'inspector' => isset($row['inspector']) ? $row['inspector'] : null,
            'inspector2' => isset($row['inspector2']) ? $row['inspector2'] : null,
            'leader_name' => isset($row['leader_name']) ? $row['leader_name'] : '',
            'supervisor_name' => isset($row['supervisor_name']) ? $row['supervisor_name'] : '', // Tambahkan kolom 'supervisor_name'
            'notes_keabnormalan' => isset($row['notes_keabnormalan']) ? $row['notes_keabnormalan'] : '' // Kolom 'notes_keabnormalan'
        );
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>
