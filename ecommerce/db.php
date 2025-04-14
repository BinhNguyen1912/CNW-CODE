<?php

//Config lại theo máy trường
$host = "localhost";
$user = "root";  // Nếu bạn đã đặt mật khẩu cho root, hãy thay đổi ở đây
$pass = "";      // Nếu có mật khẩu thì nhập vào đây
$dbname = "ecommerce";  // Đảm bảo đúng tên database của bạn
$port = 3307;   // Cổng bạn đang sử dụng

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
