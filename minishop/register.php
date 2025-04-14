<link rel="stylesheet" href="style.css">

<?php
include 'includes/header.php';
include 'config/db.php';

$errors = [];
$username = $password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate username
    if (empty($username)) {
        $errors['username'] = "Tên đăng nhập không được để trống.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
        $errors['username'] = "Tên đăng nhập phải từ 3-20 ký tự, chỉ gồm chữ, số và dấu _";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Mật khẩu không được để trống.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Mật khẩu phải từ 6 ký tự trở lên.";
    }

    // Confirm password
    if ($confirm_password !== $password) {
        $errors['confirm_password'] = "Xác nhận mật khẩu không khớp.";
    }

    //Address
    $address = trim($_POST['address'] ?? '');
    if (empty($address)) {
        $errors['address'] = "Vui lòng nhập địa chỉ.";
    }

    // Kiểm tra tài khoản đã tồn tại
    if (empty($errors)) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $errors['username'] = "Tên đăng nhập đã tồn tại.";
        }
    }

    // Insert nếu không có lỗi
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, address) VALUES (?, ?, 'user', ?)");
        $stmt->bind_param("sss", $username, $hash, $address);
        $stmt->execute();
        echo "<p style='color:green'>Đăng ký thành công! <a href='login.php'>Đăng nhập</a></p>";
        // $username = $password = $confirm_password = "";
        header("Location: login.php");
        exit;
    }
}
?>

<h3>Đăng ký</h3>
<form method="post">
    <label>
        Tên đăng nhập:
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
        <?php if (!empty($errors['username'])): ?>
            <div class="error"><?= $errors['username'] ?></div>
        <?php endif; ?>
    </label>

    <label>
        Mật khẩu:
        <input type="password" name="password">
        <?php if (!empty($errors['password'])): ?>
            <div class="error"><?= $errors['password'] ?></div>
        <?php endif; ?>
    </label>

    <label>
        Xác nhận mật khẩu:
        <input type="password" name="confirm_password">
        <?php if (!empty($errors['confirm_password'])): ?>
            <div class="error"><?= $errors['confirm_password'] ?></div>
        <?php endif; ?>
    </label>

    <label>Địa chỉ:</label>
    <input type="text" name="address" value="<?= htmlspecialchars($address ?? '') ?>">
    <?php if (isset($errors['address'])): ?>
        <div class="error"><?= $errors['address'] ?></div>
    <?php endif; ?>


    <button type="submit">Đăng ký</button>
</form>
</body>
</html>
