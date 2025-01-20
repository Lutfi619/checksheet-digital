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
        'imc61arasa' => 'imc-61arasa.html',
        'imc61flatt' => 'imc-61flat.html',
    ],
    'leader' => [
        'imc61arasa' => '../../leader/leader_check.php?type=imc61arasa',
        'imc61flatt' => '../../leader/leader_check.php?type=imc61flatt',
    ],
    'supervisor' => [
        'imc61arasa' => '../../SPV/supervisor_check.php?type=imc61arasa',
        'imc61flatt' => '../../SPV/supervisor_check.php?type=imc61flatt',
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
                <li><a href="<?= htmlspecialchars($roleLinks['imc61arasa']) ?>">Kekasaran Seal M22</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc61flatt']) ?>">Kedataran Seal M22</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
