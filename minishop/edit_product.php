<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';
$errors = [];
$name = '';
$description = '';
$price = '';
$image = '';
$oldImage = '';

// Lấy dữ liệu cũ
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" = integer
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();


    if (!$product) {
        echo "Sản phẩm không tồn tại!";
        exit;
    }

    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $oldImage = $product['image'];
}

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    
    // Validate
    if (empty($name)) $errors['name'] = "Vui lòng nhập tên sản phẩm.";
    if (empty($price) || !is_numeric($price)) $errors['price'] = "Giá không hợp lệ.";

    // Upload ảnh nếu có
    if ($_FILES['image']['name']) {
        $targetDir = "uploads/";
        $fileName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image = $fileName;

        // Xóa ảnh cũ
        if ($oldImage && file_exists("uploads/" . $oldImage)) {
            unlink("uploads/" . $oldImage);
        }
    } else {
        $image = $oldImage;
    }

    // Nếu không có lỗi -> cập nhật DB
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id); // s = string, d = double, i = int
        $stmt->execute();


        $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
        header("Location: dashboard.php");
        exit;
    }
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: #f4f4f4;  
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        max-width: 500px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        margin-top: 15px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        font-size: 0.9em;
        margin-top: 2px;
    }

    img {
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>

<h2>Sửa Sản phẩm</h2>
<form method="post" enctype="multipart/form-data">
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

    <label>Ảnh:</label><br>
    <input type="file" name="image"><br>
    <?php if ($oldImage): ?>
        <img src="uploads/<?= $oldImage ?>" width="80"><br>
    <?php endif; ?>

    <button type="submit">Cập nhật</button>
</form>
