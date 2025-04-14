<?php
include 'config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "Bạn không có quyền!";
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $get = $conn->query("SELECT image FROM products WHERE id = $id");
    if ($get->num_rows > 0) {
        $img = $get->fetch_assoc()['image'];
        if (file_exists("uploads/$img")) unlink("uploads/$img");
        $conn->query("DELETE FROM products WHERE id = $id");
    }
}
header("Location: dashboard.php");
