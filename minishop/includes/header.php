<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
        }

        header {
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: black;
        }

        header h2 {
            margin: 0;
        }

        nav a {
            color: black;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 30px;
        }

        form label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #000000;
            opacity: 0.7;
            color: white;
        }

        .actions a {
            margin-right: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header>
        <h2>TK ADMIN(TK : admin , MK : 123456)</h2>
        <nav>
            <a href="index.php">Trang chủ</a>
            <?php if (isset($_SESSION['user'])): ?>

                <!-- Nếu đề không yêu cầu Cart , xóa dòng dưới -->
                <a href="cart.php">Giỏ hàng</a>
            
            <!-- Dòng này kiểm tra nếu là admin thì mới cho truy cập 2 trang dưới -->
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="dashboard.php">Quản lý sản phẩm</a>
                <a href="users.php">Quản lý người dùng</a> 
            <?php endif; ?>
                <a href="logout.php">Đăng xuất</a>

            <!-- Nếu chưa đăng nhập (chưa có session) thì mình cho in 2 cái này -->
            <?php else: ?>
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </header>

    <!--Ý nghĩa là phần dưới là nội dung chính , vì đầy là header nên nó sẽ ở đầu trang  -->
    <main class="container">
