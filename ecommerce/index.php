<link rel="stylesheet" href="style.css">
<?php include 'includes/auth.php'; include 'db.php'; ?>
<div style="text-align: right; margin: 10px">
    <a href="logout.php">Đăng xuất</a> | 
    <?php if($_SESSION['username'] === 'admin') {
        echo "<a href='user_crud.php'>Quản lý người dùng</a> |";
    } ?>
    <a href="index.php">Danh sách sản phẩm</a> |
    <a href="add_product.php">Thêm sản phẩm</a>
</div>

<p style="text-align:left; padding: 10px; margin:0;font-size : 25px">
    Xin chào, <strong><?= $_SESSION['username'] ?? $_COOKIE['username'] ?? 'Khách' ?></strong>
</p>


<h2 style="text-align: center;">Danh sách sản phẩm</h2>

<?php
$res = $conn->query("SELECT * FROM products");

if ($res->num_rows == 0) {
    echo "<p style='color: red; text-align: center;'>Chưa có sản phẩm nào.</p>";
} else {
    echo "<table border='1' style='margin: 20px auto; width: 80%; text-align: center;'>";
    echo "<tr>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hành động</th>
          </tr>";
    
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
                <td><img src='uploads/{$row['image']}' width='50' height='50'></td>
                <td>{$row['name']}</td>
                <td>{$row['price']}</td>
                <td>{$row['description']}</td>
                <td>
                    <a href='edit_product.php?id={$row['id']}'>Sửa</a> | 
                    <a href='delete_product.php?id={$row['id']}'>Xóa</a>
                </td>
              </tr>";
    }

    echo "</table>";
}
?>
