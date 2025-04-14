<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

// Xử lý xóa sản phẩm
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $sql_delete = "DELETE FROM products WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<div class="container">
    <h2>Quản lý sản phẩm</h2>
    <p><a href="logout.php">Đăng xuất</a></p>

    <!-- Điều hướng -->
    <nav>
        <a href="add_product.php">Thêm sản phẩm</a> |
        <a href="dashboard.php">Trang chính</a>
    </nav>

    <hr>

    <h3>Danh sách sản phẩm</h3>

    <!-- Hiển thị bảng sản phẩm -->
    <table class="">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($p = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($p['description'])) ?></td>
                    <td><?= number_format($p['price'], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <?php if (!empty($p['image'])): ?>
                            <img src="<?= htmlspecialchars($p['image']) ?>" alt="Ảnh sản phẩm" width="100" height="100">
                        <?php else: ?>
                            <span>Chưa có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date("d/m/Y H:i", strtotime($p['created_at'])) ?></td>
                    <td>
                        <a href="edit_product.php?edit_id=<?= $p['id'] ?>">Sửa</a> |
                        <a href="?delete_id=<?= $p['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Chưa có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
