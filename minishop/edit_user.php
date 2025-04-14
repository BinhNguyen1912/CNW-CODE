<?php
require 'config/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';
$errors = [];
$username = '';
$address = '';
$role = 'user';

// Lấy dữ liệu cũ
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "Người dùng không tồn tại!";
        exit;
    }

    $username = $user['username'];
    $address = $user['address'];
    $role = $user['role'];
}

// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $role = $_POST['role'] ?? 'user';

    if (empty($username)) $errors['username'] = "Vui lòng nhập tên người dùng.";
    if (empty($address)) $errors['address'] = "Vui lòng nhập địa chỉ.";

    if (empty($errors)) {
        // Kiểm tra trùng username
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $errors['username'] = "Tên người dùng đã tồn tại.";
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, address = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", $username, $address, $role, $id);
            $stmt->execute();
    
            $_SESSION['success'] = "Cập nhật người dùng thành công!";
            header("Location: users.php");
            exit;
        }
    }
    
}
?>

<h2>Sửa người dùng</h2>
<form method="post">
    <label>Tên người dùng:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
    <?php if (isset($errors['username'])): ?>
        <div class="error"><?= $errors['username'] ?></div>
    <?php endif; ?>

    <label>Địa chỉ:</label>
    <input type="text" name="address" value="<?= htmlspecialchars($address) ?>">
    <?php if (isset($errors['address'])): ?>
        <div class="error"><?= $errors['address'] ?></div>
    <?php endif; ?>

    <label>Vai trò:</label>
    <select name="role">
        <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>

    <br><br>
    <button type="submit">Cập nhật</button>
</form>
