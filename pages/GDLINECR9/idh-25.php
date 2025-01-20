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
        'idh25a' => 'idh25A.html',
        'idh25b' => 'idh25B.html',
        'idh25c' => 'idh25C.html',
        'idh25d' => 'idh25D.html',
    ],
    'leader' => [
        'idh25a' => '../../leader/leader_check.php?type=idh25a',
        'idh25b' => '../../leader/leader_check.php?type=idh25b',
        'idh25c' => '../../leader/leader_check.php?type=idh25c',
        'idh25d' => '../../leader/leader_check.php?type=idh25d',
    ],
    'supervisor' => [
        'idh25a' => '../../SPV/supervisor_check.php?type=idh25a',
        'idh25b' => '../../SPV/supervisor_check.php?type=idh25b',
        'idh25c' => '../../SPV/supervisor_check.php?type=idh25c',
        'idh25d' => '../../SPV/supervisor_check.php?type=idh25d',
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
                <li><a href="<?= htmlspecialchars($roleLinks['idh25a']) ?>">Kekasaran Lubang Pipa Utama A</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh25b']) ?>">Kekasaran Lubang Pipa Utama B</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh25c']) ?>">Kekasaran Lubang Pipa Utama C</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh25d']) ?>">Kekasaran Lubang Pipa Utama D</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
