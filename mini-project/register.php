<?php
include 'config/db.php';
include 'includes/header.php';

$username = $password = $confirm_password = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate username
    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
        $errors['username'] = "Tên đăng nhập phải từ 4-20 ký tự, chỉ gồm chữ, số, dấu _";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự";
    }

    // Confirm password
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Mật khẩu xác nhận không khớp";
    }

    // Kiểm tra xem username đã tồn tại chưa
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['username'] = "Tên đăng nhập đã tồn tại";
        }
        $stmt->close();
    }

    // Nếu không có lỗi thì thêm user
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "<p class='success'>Đăng ký thành công. <a href='login.php'>Đăng nhập ngay</a></p>";
            $username = $password = $confirm_password = '';
        } else {
            echo "<p class='error'>Lỗi khi đăng ký người dùng.</p>";
        }
        $stmt->close();
    }
}
?>

<h2>Đăng ký tài khoản</h2>
<form method="POST">
    <label>Tên đăng nhập:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
    <?php if (!empty($errors['username'])): ?>
        <div class="error"><?= $errors['username'] ?></div>
    <?php endif; ?>

    <label>Mật khẩu:</label>
    <input type="password" name="password">
    <?php if (!empty($errors['password'])): ?>
        <div class="error"><?= $errors['password'] ?></div>
    <?php endif; ?>

    <label>Xác nhận mật khẩu:</label>
    <input type="password" name="confirm_password">
    <?php if (!empty($errors['confirm_password'])): ?>
        <div class="error"><?= $errors['confirm_password'] ?></div>
    <?php endif; ?>

    <button type="submit">Đăng ký</button>
</form>

