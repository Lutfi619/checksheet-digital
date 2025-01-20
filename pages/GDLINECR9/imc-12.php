<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
    header('Location: log-in.html');
    exit();
}

// Ambil role pengguna dari sesi
$role = $_SESSION['user']['role'];

// Tautan berdasarkan role
$links = [
    'user' => [
        'imc12arasa' => 'imc-12arasa.html',
        'imc12flatt' => 'imc-12flat.html',
    ],
    'leader' => [
        'imc12arasa' => '../../leader/leader_check.php?type=imc12arasa',
        'imc12flatt' => '../../leader/leader_check.php?type=imc12flatt',
    ],
    'supervisor' => [
        'imc12arasa' => '../../SPV/supervisor_check.php?type=imc12arasa',
        'imc12flatt' => '../../SPV/supervisor_check.php?type=imc12flatt',
    ],
];

// Ambil tautan sesuai role
$roleLinks = $links[$role] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pilihan</title>
    <link rel="stylesheet" href="../../css/idh-25.css">
</head>
<body>
    <div class="container">
        <h1>Pilih Item yang akan Diisi</h1>
        <ul>
            <?php if (!empty($roleLinks)): ?>
                <li><a href="<?= htmlspecialchars($roleLinks['imc12arasa']) ?>">Kekasaran Seal M22</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc12flatt']) ?>">Kedataran Seal M22</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
