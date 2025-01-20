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
        '902fb94arasam20' => '902FB-94arasam20.html',
        '902fb94arasam10' => '902FB-94arasam10.html',
        '902fb94arasa176' => '902FB-94arasa176.html',
        '902fb94flatm10' => '902FB-94flatm10.html',
        '902fb94flatm20' => '902FB-94flatm20.html',
    ],
    'leader' => [
        '902fb94arasam10' => '../../leader/leader_check.php?type=902fb94arasam10',
        '902fb94flatm10' => '../../leader/leader_check.php?type=902fb94flatm10',
        '902fb94arasam20' => '../../leader/leader_check.php?type=902fb94arasam20',
        '902fb94flatm20' => '../../leader/leader_check.php?type=902fb94flatm20',
        '902fb94arasa176' => '../../leader/leader_check.php?type=902fb94arasa176',
    ],
    'supervisor' => [
        '902fb94arasam10' => '../../leader/leader_check.php?type=902fb94arasam10',
        '902fb94flatm10' => '../../leader/leader_check.php?type=902fb94flatm10',
        '902fb94arasam20' => '../../leader/leader_check.php?type=902fb94arasam20',
        '902fb94flatm20' => '../../leader/leader_check.php?type=902fb94flatm20',
        '902fb94arasa176' => '../../leader/leader_check.php?type=902fb94arasa176',
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
                <li><a href="<?= htmlspecialchars($roleLinks['902fb94arasam20']) ?>">Kekasaran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['902fb94flatm20']) ?>">Kedataran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['902fb94arasam10']) ?>">Kekasaran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['902fb94flatm10']) ?>">Kedataran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['902fb94arasa176']) ?>">Kekasaran Seal Ø17.6</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
