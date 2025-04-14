<?php
include 'db.php';

// Thêm hoặc cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if ($id) {
        // Cập nhật
        $stmt = $conn->prepare("UPDATE users SET username=?, password=?, address=?, phone=? WHERE id=?");
        $stmt->bind_param("ssssi", $username, $password, $address, $phone, $id);
        $stmt->execute();
    } else {
        // Thêm mới
        $stmt = $conn->prepare("INSERT INTO users (username, password, address, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $address, $phone);
        $stmt->execute();
    }

    header("Location: user_crud.php");
    exit();
}

// Xóa người dùng
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: user_crud.php");
    exit();
}
?>