<?php
include 'includes/header.php';
include 'config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập!";
    exit;
}

$products = $conn->query("SELECT * FROM products");
?>

<h3>Quản lý sản phẩm</h3>
<a href="add_product.php"> +  Thêm sản phẩm</a>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Ảnh</th>
        <th>Tên SP</th>
        <th>Giá SP</th>
        <th>Thao tác</th>
    </tr> a
    <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
            <td><img src="uploads/<?= $row['image'] ?>" width="80"></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price']) ?> VNĐ</td>
            <td>
                <a href="edit_product.php?id=<?= $row['id'] ?>">Sửa</a> |
                <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>

        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
