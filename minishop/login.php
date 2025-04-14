<link rel="stylesheet" href="style.css">

<?php
include 'includes/header.php';
include 'config/db.php';

$username = $password = "";
$errors = [];
// Kiểm tra xem form có được submit bằng phương thức POST hay không.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập.";
    }
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute(); //Thực thi câu lệnh SQL với giá trị $username đã bind ở trên.
        $res = $stmt->get_result(); // Lấy kết quả truy vấn từ câu lệnh đã thực th

        if ($res->num_rows === 1) { //Kiểm tra xem có đúng 1 người dùng có username đó hay không.
            $user = $res->fetch_assoc(); //Lấy dữ liệu của user thành mảng kết hợp (associative array).
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                if (isset($_POST['remember'])) {
                    setcookie("username", $username, time() + 180);
                    setcookie("password", $password, time() + 180);
                }
                header("Location: index.php");
                exit;
            } else {
                $errors['password'] = "Mật khẩu không đúng.";
            }
        } else {
            $errors['username'] = "Tài khoản không tồn tại.";
        }
    }
}
?>

<h3>Đăng nhập</h3>
<form method="post">
    <label>
        Tên đăng nhập:
        <input type="text" name="username" value="<?= isset($_COOKIE['username']) ? $_COOKIE['username'] : '' ?>">
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
        <input type="checkbox" name="remember"> Ghi nhớ tôi
    </label>

    <button type="submit">Đăng nhập</button>
</form>
</body>
</html>
