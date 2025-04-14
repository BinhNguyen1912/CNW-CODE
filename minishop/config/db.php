<?php
//Config lại theo mấy trường
$host = "localhost";
$user = "root";  // Nếu bạn đã đặt mật khẩu cho root, hãy thay đổi ở đây
$pass = "";      // Nếu có mật khẩu thì nhập vào đây
$dbname = "minishop";  // Đảm bảo đúng tên database của bạn (CHÚ Ý ĐỔI TÊN CHỔ NÀYNÀY)
$port = 3307;   // Cổng bạn đang sử dụng (CHÚ Ý , ĐỔI TÊN CỔNG TRÊN MÁY TRƯỜNG)

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


/* 
CREATE DATABASE minishop;
USE minishop;
--Bảng users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user'
);
--Bảng products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE users ADD address VARCHAR(255) AFTER username;


 */
?>
