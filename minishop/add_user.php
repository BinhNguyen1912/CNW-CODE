<?php
require 'config/db.php';
include 'includes/header.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$errors = [];
$username = '';
$password = '';
$address = '';
$role = 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $role = $_POST['role'] ?? 'user';

    // Validate
    if (empty($username)) $errors['username'] = "Vui lòng nhập tên người dùng.";
    if (empty($password)) $errors['password'] = "Vui lòng nhập mật khẩu.";
    if (empty($address)) $errors['address'] = "Vui lòng nhập địa chỉ.";

    // Kiểm tra username đã tồn tại chưa
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['username'] = "Tên người dùng đã tồn tại.";
        }
    }

    // Thêm vào DB nếu không có lỗi
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, address, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashedPassword, $address, $role);
        $stmt->execute();

        $_SESSION['success'] = "Thêm người dùng mới thành công!";
        header("Location: users.php");
        exit;
    }
}
?>

<h2>Thêm người dùng mới</h2>
<form method="post">
    <label>Tên người dùng:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
    <?php if (isset($errors['username'])): ?>
        <div class="error"><?= $errors['username'] ?></div>
    <?php endif; ?>

    <label>Mật khẩu:</label>
    <input type="password" name="password">
    <?php if (isset($errors['password'])): ?>
        <div class="error"><?= $errors['password'] ?></div>
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
    <button type="submit">Thêm mới</button>
</form>
