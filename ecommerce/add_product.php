<?php
// session_start();
include('db.php');

$nameErr = $priceErr = $imageErr = "";
$name = $price = $description = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $description = trim($_POST['description']);

    $isValid = true;

    // Tên sản phẩm
    if (empty($name)) {
        $nameErr = "Tên sản phẩm không được để trống.";
        $isValid = false;
    }

    // Giá sản phẩm
    if (!is_numeric($price) || $price <= 0) {
        $priceErr = "Giá sản phẩm phải là số dương.";
        $isValid = false;
    }

    // Ảnh sản phẩm
    if ($_FILES['image']['error'] !== 0) {
        $imageErr = "Vui lòng chọn ảnh sản phẩm.";
        $isValid = false;
    }

    if ($isValid) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $query = "INSERT INTO products (name, price, image, description)
                  VALUES ('$name', '$price', '$image', '$description')";

        if (mysqli_query($conn, $query)) {
            echo "<p style='color: green;'>Thêm sản phẩm thành công!</p>";
            // Reset lại input sau khi thêm
            $name = $price = $description = "";
            header("Location: index.php");
        } else {
            echo "<p style='color: red;'>Lỗi khi thêm sản phẩm vào cơ sở dữ liệu.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group { margin-bottom: 15px; }
        .error { color: red; font-size: 0.9em; margin-top: 4px; }
        input, textarea { width: 100%; padding: 8px; }
    </style>
</head>
<body>
<?php include 'includes/auth.php'; include 'db.php'; ?>

<div style="text-align: right; margin: 10px">
    <a href="logout.php">Đăng xuất</a> | 
    <?php if($_SESSION['username'] === 'admin') {
        echo "<a href='user_crud.php'>Quản lý người dùng</a> |";
    } ?>
    <a href="index.php">Danh sách sản phẩm</a> |
    <a href="add_product.php">Thêm sản phẩm</a>
</div>
    <h2>Thêm sản phẩm</h2>

    <form method="POST" enctype="multipart/form-data" style="width: 50%;">
        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
            <?php if ($nameErr): ?><div class="error"><?= $nameErr ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Giá:</label>
            <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($price) ?>">
            <?php if ($priceErr): ?><div class="error"><?= $priceErr ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Mô tả:</label>
            <textarea name="description"><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-group">
            <label>Ảnh sản phẩm:</label>
            <input type="file" name="image">
            <?php if ($imageErr): ?><div class="error"><?= $imageErr ?></div><?php endif; ?>
        </div>

        <button type="submit">Thêm</button>
    </form>
</body>
</html>
