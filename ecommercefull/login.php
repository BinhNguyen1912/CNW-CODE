<link rel="stylesheet" href="style/style.css">
<?php
session_start();
include('includes/db.php');

$username_err = $password_err = "";
$username = $password = "";

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

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // Chuyển hướng người dùng đến trang chủ hoặc trang khác sau khi đăng nhập thành công
                header("Location: dashboard.php");
                exit();
            } else {
                $password_err = "Sai mật khẩu!";
            }
        } else {
            $username_err = "Tên người dùng không tồn tại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng Nhập</h2>
    <form method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="text" name="username" id="username" value="<?= $username ?>" required>
        <span style="color:red"><?= $username_err ?></span><br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required>
        <span style="color:red"><?= $password_err ?></span><br><br>

        <button type="submit">Đăng nhập</button>
    </form>

    <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay!</a></p>
</body>
</html>
