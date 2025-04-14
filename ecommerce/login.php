<link rel="stylesheet" href="style.css">

<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['username'] = $username;

        if (isset($_POST['remember'])) {
            setcookie("username", $username, time() + 60);
        }

        header("Location: index.php");
    } else {
        $err = "<p style='color: red'>Sai tài khoản hoặc mật khẩu!</p>";
    }
}
?>

<form method="POST">                                               
    <h2>Đăng nhập</h2>
    <input type="text" name="username" placeholder="Tên đăng nhập" value="<?= $_COOKIE['username'] ?? ''?>"><br>
    <input type="password" name="password" placeholder="Mật khẩu" ><br>
    <lable><input type="checkbox" name="remember" style="display: inline-block; width: 30px"> Ghi nhớ đăng nhập</lable>
    <a href="register.php" style="margin-left: 50px">Đăng ký</a>

    <?= $err ?? '' ?>
    <button type="submit">Đăng nhập</button>
</form>
