<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/db.php';
$username = $_SESSION['username'];

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chính</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <h2>Xin chào, <?= htmlspecialchars($username) ?>!</h2>
        <p><a href="logout.php">Đăng xuất</a></p>

        <!-- Điều hướng -->
        <nav>
            <a href="products/add_product.php">Thêm sản phẩm</a> |
            <a href="products/index.php">Quản lý sản phẩm</a>
        </nav>

        <hr>

        <h3>Danh sách sản phẩm mới nhất</h3>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($p = $result->fetch_assoc()): ?>
                <table style="width:100%; border:1px solid #ccc; margin-bottom:10px; padding:10px;">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td><?= nl2br(htmlspecialchars($p['description'])) ?></td>
                    </tr>
                    <tr>
                        <th>Giá</th>
                        <td><?= number_format($p['price'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                    <tr>
                        <th>Ảnh</th>
                        <td>
                            <?php if (!empty($p['image'])): ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="Ảnh sản phẩm" width="100">
                            <?php else: ?>
                                Chưa có ảnh
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td><?= date("d/m/Y H:i", strtotime($p['created_at'])) ?></td>
                    </tr>
                </table>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm nào.</p>
        <?php endif; ?>
    </div>
</body>
</html>
