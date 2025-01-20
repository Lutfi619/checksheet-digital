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
        '110arasam20' => '110arasam20.html',
        '110arasam10' => '110arasam10.html',
        '110arasa176' => '110arasa176.html',
        '110flatm10' => '110flatm10.html',
        '110flatm20' => '110flatm20.html',
    ],
    'leader' => [
        '110arasam10' => '../../leader/leader_check.php?type=110arasam10',
        '110flatm10' => '../../leader/leader_check.php?type=110flatm10',
        '110arasam20' => '../../leader/leader_check.php?type=110arasam20',
        '110flatm20' => '../../leader/leader_check.php?type=110flatm20',
        '110arasa176' => '../../leader/leader_check.php?type=110arasa176',
    ],
    'supervisor' => [
        '110arasam10' => '../../leader/leader_check.php?type=110arasam10',
        '110flatm10' => '../../leader/leader_check.php?type=110flatm10',
        '110arasam20' => '../../leader/leader_check.php?type=110arasam20',
        '110flatm20' => '../../leader/leader_check.php?type=110flatm20',
        '110arasa176' => '../../leader/leader_check.php?type=110arasa176',
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
                <li><a href="<?= htmlspecialchars($roleLinks['110arasam20']) ?>">Kekasaran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['110flatm20']) ?>">Kedataran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['110arasam10']) ?>">Kekasaran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['110flatm10']) ?>">Kedataran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['110arasa176']) ?>">Kekasaran Seal Ø17.6</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
