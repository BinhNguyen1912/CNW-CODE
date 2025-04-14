<?php
include('db.php');

// Truy vấn lấy sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Lưu sản phẩm vào một mảng
    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="add_product.php">Thêm sản phẩm</a></li>
        </ul>
    </nav>

    <h2>Danh sách sản phẩm</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="70" height="70"></td>
                    <td>
                        <a href="update_product.php?id=<?php echo $product['id']; ?>">Sửa</a> |
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
