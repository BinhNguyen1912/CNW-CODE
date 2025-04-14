<?php
include 'includes/header.php';
include 'config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập!";
    exit;
}

$name = $description = $price = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $image = $_FILES['image'];

    if (!$name) $errors['name'] = "Tên sản phẩm không được bỏ trống.";
    if (!$price || !is_numeric($price) || $price <= 0) $errors['price'] = "Giá sản phẩm không hợp lệ.";
    if ($image['error'] == 4) $errors['image'] = "Vui lòng chọn hình ảnh.";

    if (empty($errors)) {
        $imgName = time() . '_' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], "uploads/$imgName");

        $stmt = $conn->prepare("INSERT INTO products(name, description, price, image, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssds", $name, $description, $price, $imgName);
        $stmt->execute();
        echo "<p style='color:green'>Thêm sản phẩm thành công!</p>";
        $name = $description = $price = "";
        header("Location: dashboard.php");
    }
}
?>

<h3>Thêm sản phẩm mới</h3>
<form method="post" enctype="multipart/form-data">
    <label>Tên sản phẩm:
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <?php if (!empty($errors['name'])): ?><div class="error"><?= $errors['name'] ?></div><?php endif; ?>
    </label>

    <label>Mô tả:
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea>
    </label>

    <label>Giá:
        <input type="text" name="price" value="<?= htmlspecialchars($price) ?>">
        <?php if (!empty($errors['price'])): ?><div class="error"><?= $errors['price'] ?></div><?php endif; ?>
    </label>

    <label>Hình ảnh:
        <input type="file" name="image">
        <?php if (!empty($errors['image'])): ?><div class="error"><?= $errors['image'] ?></div><?php endif; ?>
    </label>

    <button type="submit">Thêm</button> <br> <button><a href="dashboard.php">Hủy</a></button>
    
</form>
</body>
</html>
