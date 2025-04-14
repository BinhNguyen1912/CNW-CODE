<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mini Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Mini PHP Project</h1>
    <nav>
        <a href="index.php">Trang chủ</a>
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
        <?php else: ?>
            <a href="dashboard.php">Quản lý</a>
            <a href="logout.php">Đăng xuất (<?= $_SESSION['user']['username'] ?>)</a>
        <?php endif; ?>
    </nav>
</header>
<main>
