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
        'imc103arasam20' => 'imc-103arasam20.html',
        'imc103arasam10' => 'imc-103arasam10.html',
        'imc103arasa176' => 'imc-103arasa176.html',
        'imc103flatm10' => 'imc-103flatm10.html',
        'imc103flatm20' => 'imc-103flatm20.html',
    ],
    'leader' => [
        'imc103arasam10' => '../../leader/leader_check.php?type=imc103arasam10',
        'imc103flatm10' => '../../leader/leader_check.php?type=imc103flatm10',
        'imc103arasam20' => '../../leader/leader_check.php?type=imc103arasam20',
        'imc103flatm20' => '../../leader/leader_check.php?type=imc103flatm20',
        'imc103arasa176' => '../../leader/leader_check.php?type=imc103arasa176',
    ],
    'supervisor' => [
        'imc103arasam10' => '../../leader/leader_check.php?type=imc103arasam10',
        'imc103flatm10' => '../../leader/leader_check.php?type=imc103flatm10',
        'imc103arasam20' => '../../leader/leader_check.php?type=imc103arasam20',
        'imc103flatm20' => '../../leader/leader_check.php?type=imc103flatm20',
        'imc103arasa176' => '../../leader/leader_check.php?type=imc103arasa176',
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
                <li><a href="<?= htmlspecialchars($roleLinks['imc103arasam20']) ?>">Kekasaran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc103flatm20']) ?>">Kedataran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc103arasam10']) ?>">Kekasaran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc103flatm10']) ?>">Kedataran Seal M10</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['imc103arasa176']) ?>">Kekasaran Seal Ø17.6</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
