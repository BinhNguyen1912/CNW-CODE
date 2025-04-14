<?php

//Config lại theo máy trường
$host = "localhost";
$user = "root";  // Nếu bạn đã đặt mật khẩu cho root, hãy thay đổi ở đây
$pass = "";      // Nếu có mật khẩu thì nhập vào đây
$dbname = "mini_project";  // Đảm bảo đúng tên database của bạn (doi cho nay)
$port = 3307;   // Cổng bạn đang sử dụng (doi cho nay)

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


/* 
 CREATE DATABASE mini_project;

USE mini_project;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price FLOAT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

 */
?>
