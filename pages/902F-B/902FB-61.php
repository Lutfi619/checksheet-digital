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
        '902fb61arasa' => '902FB-61arasa.html',
        '902fb61round' => '902FB-61round.html',
    ],
    'leader' => [
        '902fb61arasa' => '../../leader/leader_check.php?type=902fb61arasa',
        '902fb61round' => '../../leader/leader_check.php?type=902fb61round',
    ],
    'supervisor' => [
        '902fb61arasa' => '../../SPV/supervisor_check.php?type=902fb61arasa',
        '902fb61round' => '../../SPV/supervisor_check.php?type=902fb61round',
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
                <li><a href="<?= htmlspecialchars($roleLinks['902fb61arasa']) ?>">Kekasaran Seal M20</a></li>
                <li><a href="<?= htmlspecialchars($roleLinks['902fb61round']) ?>">Kebulatan Seal M20</a></li>
            <?php else: ?>
                <li>Role Anda tidak memiliki akses ke tautan ini.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
