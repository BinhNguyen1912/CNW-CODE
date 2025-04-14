<link rel="stylesheet" href="style.css">


<?php
include 'includes/auth.php';
include 'db.php';

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $img = $product['image'];

    if ($_FILES['image']['name']) {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=?, description=? WHERE id=?");
    $stmt->bind_param("sdssi", $name, $price, $img, $desc, $id);
    $stmt->execute();
    header("Location: index.php");
}
?>
<div style="text-align: right; margin: 10px">
    <a href="logout.php">Đăng xuất</a> | 
    <?php if($_SESSION['username'] === 'admin') {
        echo "<a href='user_crud.php'>Quản lý người dùng</a> |";
    } ?>
    <a href="index.php">Danh sách sản phẩm</a> |
    <a href="add_product.php">Thêm sản phẩm</a>
</div>
<form method="POST" enctype="multipart/form-data">
    <h2>Sửa sản phẩm</h2>
    <input type="text" name="name" value="<?= $product['name'] ?>"><br>
    <input type="number" name="price" value="<?= $product['price'] ?>"><br>
    <textarea name="description"><?= $product['description'] ?></textarea><br>
    <input type="file" name="image"><br>
    <img src="uploads/<?= $product['image'] ?>" width="100" height="100" style="margin: 10px"><br>
    <button type="submit">Lưu</button>
</form>
