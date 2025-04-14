<?php
session_start();
require_once '../includes/db.php';

$errors = [];
$name = $description = $price = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = trim($_POST["price"]);
    $imagePath = '';

    // Kiểm tra
    if (empty($name)) $errors['name'] = "Tên sản phẩm không được để trống";
    if (empty($price) || !is_numeric($price)) $errors['price'] = "Giá không hợp lệ";

    // Upload ảnh
    if ($_FILES['image']['name']) {
        $targetDir = "/uploads"; // Đặt thư mục uploads
        $filename = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $filename;

        // Kiểm tra loại file ảnh
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $validTypes)) {
            $errors['image'] = "Chỉ chấp nhận ảnh JPG, PNG, GIF";
        } else {
            // Di chuyển ảnh từ tạm thời vào thư mục uploads
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = "uploads/" . $filename;
            } else {
                $errors['image'] = "Không thể tải ảnh lên.";
            }
        }
    }

    // Thêm vào DB nếu không có lỗi
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssds", $name, $description, $price, $imagePath);
        $stmt->execute();
        header("Location: add_product.php");
        exit();
    }
}

// Lấy sản phẩm ra bảng bên dưới
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<div style="text-align: right ; margin: 20px">
    <a href="../dashboard.php">Dashboard</a>|
    <a href="/products/add_product.php">Thêm sản phẩm</a>|
    <a href="/products/index.php">Danh sách sản phẩm</a> 
</div>
<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"><br>
        <?php if (isset($errors['name'])): ?>
            <small style="color:red"><?= $errors['name'] ?></small><br>
        <?php endif; ?>

        <label>Mô tả:</label><br>
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea><br>

        <label>Giá:</label><br>
        <input type="text" name="price" value="<?= htmlspecialchars($price) ?>"><br>
        <?php if (isset($errors['price'])): ?>
            <small style="color:red"><?= $errors['price'] ?></small><br>
        <?php endif; ?>

        <label>Ảnh sản phẩm:</label><br>
        <input type="file" name="image"><br>
        <?php if (isset($errors['image'])): ?>
            <small style="color:red"><?= $errors['image'] ?></small><br>
        <?php endif; ?>

        <br>
        <button type="submit">Thêm sản phẩm</button>
    </form>

    <hr>
    <h3>Danh sách sản phẩm</h3>
    <?php if ($result && $result->num_rows > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Ngày tạo</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= number_format($row['price'], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="../<?= $row['image'] ?>" width="60">
                        <?php endif; ?>
                    </td>
                    <td><?= date("d/m/Y H:i", strtotime($row['created_at'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Chưa có sản phẩm nào.</p>
    <?php endif; ?>
</div>
</body>
</html>
