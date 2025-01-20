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
        'idh46a' => 'idh46A.html',
        'idh46b' => 'idh46B.html',
        'idh46c' => 'idh46C.html',
        'idh46d' => 'idh46D.html',
    ],
    'leader' => [
        'idh46a' => '../../leader/leader_check.php?type=idh46a',
        'idh46b' => '../../leader/leader_check.php?type=idh46b',
        'idh46c' => '../../leader/leader_check.php?type=idh46c',
        'idh46d' => '../../leader/leader_check.php?type=idh46d',
    ],
    'supervisor' => [
        'idh46a' => '../../SPV/supervisor_check.php?type=idh46a',
        'idh46b' => '../../SPV/supervisor_check.php?type=idh46b',
        'idh46c' => '../../SPV/supervisor_check.php?type=idh46c',
        'idh46d' => '../../SPV/supervisor_check.php?type=idh46d',
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
                <li><a href="<?= htmlspecialchars($roleLinks['idh46a']) ?>">Kekasaran Lubang Pipa Utama A</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh46b']) ?>">Kekasaran Lubang Pipa Utama B</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh46c']) ?>">Kekasaran Lubang Pipa Utama C</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh46d']) ?>">Kekasaran Lubang Pipa Utama D</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
