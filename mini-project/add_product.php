<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

// Nếu chưa đăng nhập thì chuyển về login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$name = $description = $price = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $imageName = '';

    // Validate
    if (empty($name)) {
        $errors['name'] = "Vui lòng nhập tên sản phẩm";
    }

    if (empty($description)) {
        $errors['description'] = "Vui lòng nhập mô tả";
    }

    if (empty($price) || !is_numeric($price) || $price < 0) {
        $errors['price'] = "Vui lòng nhập giá hợp lệ";
    }

    // Xử lý upload ảnh
    if ($_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $imageName);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit;
    }
}
?>

<h2>Thêm sản phẩm</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Tên sản phẩm:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"><br>
    <?php if (!empty($errors['name'])): ?>
        <div class="error"><?= $errors['name'] ?></div>
    <?php endif; ?>

    <label>Mô tả:</label><br>
    <textarea name="description"><?= htmlspecialchars($description) ?></textarea><br>
    <?php if (!empty($errors['description'])): ?>
        <div class="error"><?= $errors['description'] ?></div>
    <?php endif; ?>

    <label>Giá (VNĐ):</label><br>
    <input type="text" name="price" value="<?= htmlspecialchars($price) ?>"><br>
    <?php if (!empty($errors['price'])): ?>
        <div class="error"><?= $errors['price'] ?></div>
    <?php endif; ?>

    <label>Ảnh:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Thêm sản phẩm</button>
</form>

<p><a href="index.php">← Quay lại danh sách</a></p>

<?php include 'includes/footer.php'; ?>
