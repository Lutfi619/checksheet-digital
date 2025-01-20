<?php
header('Content-Type: application/json');

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengukuran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Ambil data dari form
$date = !empty($_POST['date']) ? $_POST['date'] : null;
$hatsumono1 = isset($_POST['hatsumono1']) && $_POST['hatsumono1'] !== '' ? $_POST['hatsumono1'] : null;
$hatsumono2 = isset($_POST['hatsumono2']) && $_POST['hatsumono2'] !== '' ? $_POST['hatsumono2'] : null;
$inspector = !empty($_POST['inspector']) ? $_POST['inspector'] : null;
$inspector2 = !empty($_POST['inspector2']) ? $_POST['inspector2'] : null;
$notes_keabnormalan = !empty($_POST['notes_keabnormalan']) ? $_POST['notes_keabnormalan'] : null;
$table = isset($_POST['table']) ? $_POST['table'] : 'idh25a';

if (empty($date)) {
    echo json_encode(['status' => 'error', 'message' => 'Tanggal tidak boleh kosong']);
    $conn->close();
    exit();
}

// Cek apakah data dengan tanggal yang sama sudah ada
$sql_check = $conn->prepare("SELECT * FROM $table WHERE date = ?");
$sql_check->bind_param('s', $date);
$sql_check->execute();
$result = $sql_check->get_result();

$average = null;
$min_value = null;
$max_value = null;
$range_value = null;

if ($result->num_rows > 0) {
    // Jika data dengan tanggal yang sama sudah ada, ambil data lama
    $existing_data = $result->fetch_assoc();
    
    // Isi kolom kosong dengan data baru
    if ($hatsumono1 !== null) {
        $existing_data['hatsumono1'] = $hatsumono1;
    }
    if ($hatsumono2 !== null) {
        $existing_data['hatsumono2'] = $hatsumono2;
    }
    if ($inspector !== null) {
        $existing_data['inspector'] = $inspector;
    }
    if ($inspector2 !== null) {
        $existing_data['inspector2'] = $inspector2;
    }
    if ($notes_keabnormalan !== null) {
        $existing_data['notes_keabnormalan'] = $notes_keabnormalan;
    }

    // Hitung ulang average, min_value, max_value, dan range_value hanya jika kedua nilai ada
    if ($existing_data['hatsumono1'] !== null && $existing_data['hatsumono2'] !== null) {
        $average = ($existing_data['hatsumono1'] + $existing_data['hatsumono2']) / 2;
        $min_value = min($existing_data['hatsumono1'], $existing_data['hatsumono2']);
        $max_value = max($existing_data['hatsumono1'], $existing_data['hatsumono2']);
        $range_value = $max_value - $min_value;
    }

    // Siapkan variabel untuk bind_param
    $hatsumono1_update = $existing_data['hatsumono1'];
    $hatsumono2_update = $existing_data['hatsumono2'];
    $average_update = $average !== null ? $average : $existing_data['average'];
    $min_value_update = $min_value !== null ? $min_value : $existing_data['min_value'];
    $max_value_update = $max_value !== null ? $max_value : $existing_data['max_value'];
    $range_value_update = $range_value !== null ? $range_value : $existing_data['range_value'];
    $inspector_update = $existing_data['inspector'];
    $inspector2_update = $existing_data['inspector2'];
    $notes_keabnormalan_update = $existing_data['notes_keabnormalan'];

    // Update data yang ada
    $sql_update = $conn->prepare("UPDATE $table SET hatsumono1 = ?, hatsumono2 = ?, average = ?, min_value = ?, max_value = ?, range_value = ?, inspector = ?, inspector2 = ?, notes_keabnormalan = ? WHERE date = ?");
    $sql_update->bind_param('ddddddssss', 
                            $hatsumono1_update, 
                            $hatsumono2_update, 
                            $average_update, 
                            $min_value_update, 
                            $max_value_update, 
                            $range_value_update, 
                            $inspector_update, 
                            $inspector2_update, 
                            $notes_keabnormalan_update, 
                            $date);

    if ($sql_update->execute()) {
        echo json_encode(["status" => "success", "message" => "Data berhasil diupdate!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal mengupdate data: " . $sql_update->error]);
    }

} else {
    // Cek batas jumlah data
    $sql_count = $conn->prepare("SELECT COUNT(*) AS count FROM $table");
    $sql_count->execute();
    $result_count = $sql_count->get_result();
    $count_data = $result_count->fetch_assoc()['count'];

    if ($count_data >= 25) {
        echo json_encode(['status' => 'warning', 'message' => "Data sudah mencapai batas maksimal!"]);
        $conn->close();
        exit();
    }

    // Tambahkan entri baru jika tidak ada data sebelumnya
    if ($hatsumono1 !== null && $hatsumono2 !== null) {
        $average = ($hatsumono1 + $hatsumono2) / 2;
        $min_value = min($hatsumono1, $hatsumono2);
        $max_value = max($hatsumono1, $hatsumono2);
        $range_value = $max_value - $min_value;
    }

    // Siapkan variabel untuk bind_param
    $hatsumono1_insert = $hatsumono1;
    $hatsumono2_insert = $hatsumono2;
    $average_insert = $average !== null ? $average : 0;
    $min_value_insert = $min_value !== null ? $min_value : 0;
    $max_value_insert = $max_value !== null ? $max_value : 0;
    $range_value_insert = $range_value !== null ? $range_value : 0;
    $inspector_insert = $inspector;
    $inspector2_insert = $inspector2;
    $notes_keabnormalan_insert = $notes_keabnormalan;

    $sql_insert = $conn->prepare("INSERT INTO $table (date, hatsumono1, hatsumono2, average, min_value, max_value, range_value, inspector, inspector2, notes_keabnormalan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql_insert->bind_param('sddddddsss', 
                            $date, 
                            $hatsumono1_insert, 
                            $hatsumono2_insert, 
                            $average_insert, 
                            $min_value_insert, 
                            $max_value_insert, 
                            $range_value_insert, 
                            $inspector_insert, 
                            $inspector2_insert, 
                            $notes_keabnormalan_insert);

    if ($sql_insert->execute()) {
        echo json_encode(["status" => "success", "message" => "Data baru berhasil diinput!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menambah data baru: " . $sql_insert->error]);
    }
}

// Tutup koneksi
$conn->close();
?>
