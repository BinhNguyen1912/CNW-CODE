<?php
session_start();
include('db.php');  // Kết nối với database

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $is_valid = true;
    if($password != $confirm_password){
        $is_valid = false;
    }
    // Kiểm tra nếu tên người dùng đã tồn tại
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        //   echo("<p style='color: red'>Tên người dùng đã tồn tại!</p>");
          $errUserName = "<p style='color: red'>Tên người dùng đã tồn tại!</p>";
    } else if($is_valid == false){
                $err = '<p style="color: red">Mật khóa khong khop</p>';
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            // Đăng ký thành công, chuyển hướng về trang index
            setcookie("username", $username, time() + 60);

            header('Location: index.php');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Ký Tài Khoản</h2>
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            <?= $errUserName ?? '' ?>   
            <?= $err ?? '' ?>
            <button type="submit">Đăng ký</button>
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        </form>
        
    </div>
</body>
</html>
