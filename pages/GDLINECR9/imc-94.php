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
        'imc94arasam20' => 'imc-94arasam20.html',
        'imc94arasam10' => 'imc-94arasam10.html',
        'imc94arasa176' => 'imc-94arasa176.html',
        'imc94flatm10' => 'imc-94flatm10.html',
        'imc94flatm20' => 'imc-94flatm20.html',
    ],
    'leader' => [
        'imc94arasam10' => '../../leader/leader_check.php?type=imc94arasam10',
        'imc94flatm10' => '../../leader/leader_check.php?type=imc94flatm10',
        'imc94arasam20' => '../../leader/leader_check.php?type=imc94arasam20',
        'imc94flatm20' => '../../leader/leader_check.php?type=imc94flatm20',
        'imc94arasa176' => '../../leader/leader_check.php?type=imc94arasa176',
    ],
    'supervisor' => [
        'imc94arasam10' => '../../leader/leader_check.php?type=imc94arasam10',
        'imc94flatm10' => '../../leader/leader_check.php?type=imc94flatm10',
        'imc94arasam20' => '../../leader/leader_check.php?type=imc94arasam20',
        'imc94flatm20' => '../../leader/leader_check.php?type=imc94flatm20',
        'imc94arasa176' => '../../leader/leader_check.php?type=imc94arasa176',
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
                <li><a href="<?= htmlspecialchars($roleLinks['imc94arasam20']) ?>">Kekasaran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc94flatm20']) ?>">Kedataran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc94arasam10']) ?>">Kekasaran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc94flatm10']) ?>">Kedataran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc94arasa176']) ?>">Kekasaran Seal Ø17.6</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
