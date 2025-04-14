<link rel="stylesheet" href="style/style.css">
<?php
include('includes/db.php');

$username_err = $password_err = $confirm_password_err = "";
$username = $password = $confirm_password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra tên người dùng
    if (empty($_POST['username'])) {
        $username_err = "Tên người dùng là bắt buộc.";
    } else {
        $username = $_POST['username'];
    }

    // Kiểm tra mật khẩu
    if (empty($_POST['password'])) {
        $password_err = "Mật khẩu là bắt buộc.";
    } else {
        $password = $_POST['password'];
    }

    // Kiểm tra xác nhận mật khẩu
    if (empty($_POST['confirm_password'])) {
        $confirm_password_err = "Xác nhận mật khẩu là bắt buộc.";
    } else {
        $confirm_password = $_POST['confirm_password'];
        if ($password !== $confirm_password) {
            $confirm_password_err = "Mật khẩu không khớp.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra xem tên người dùng đã tồn tại chưa
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $username_err = "Tên người dùng đã tồn tại.";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hashed')";
            if ($conn->query($sql) === TRUE) {
                // Chuyển hướng người dùng đến trang login sau khi đăng ký thành công
                header("Location: login.php");
                exit();
            } else {
                echo "Lỗi: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
</head>
<body>
    <h2>Đăng Ký</h2>
    <form method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="text" name="username" id="username" value="<?= $username ?>" required>
        <span style="color:red"><?= $username_err ?></span><br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required>
        <span style="color:red"><?= $password_err ?></span><br><br>

        <label for="confirm_password">Xác nhận mật khẩu:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <span style="color:red"><?= $confirm_password_err ?></span><br><br>

        <button type="submit">Đăng ký</button>
    </form>

    <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay!</a></p>
</body>
</html>
