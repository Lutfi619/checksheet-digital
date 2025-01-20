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
        'idh23a' => 'idh23A.html',
        'idh23b' => 'idh23B.html',
        'idh23c' => 'idh23C.html',
        'idh23d' => 'idh23D.html',
    ],
    'leader' => [
        'idh23a' => '../../leader/leader_check.php?type=idh23a',
        'idh23b' => '../../leader/leader_check.php?type=idh23b',
        'idh23c' => '../../leader/leader_check.php?type=idh23c',
        'idh23d' => '../../leader/leader_check.php?type=idh23d',
    ],
    'supervisor' => [
        'idh23a' => '../../SPV/supervisor_check.php?type=idh23a',
        'idh23b' => '../../SPV/supervisor_check.php?type=idh23b',
        'idh23c' => '../../SPV/supervisor_check.php?type=idh23c',
        'idh23d' => '../../SPV/supervisor_check.php?type=idh23d',
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
                <li><a href="<?= htmlspecialchars($roleLinks['idh23a']) ?>">Kekasaran Lubang Pipa Utama A</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh23b']) ?>">Kekasaran Lubang Pipa Utama B</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh23c']) ?>">Kekasaran Lubang Pipa Utama C</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['idh23d']) ?>">Kekasaran Lubang Pipa Utama D</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
