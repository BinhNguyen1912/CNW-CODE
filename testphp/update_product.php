<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        
        // Xử lý ảnh tải lên
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image']['name'];
            $target = "uploads/" . basename($image);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $sql = "UPDATE products SET name = '$name', price = '$price', image = '$image' WHERE id = $id";
                if ($conn->query($sql) === TRUE) {
                    echo "Sản phẩm đã được cập nhật thành công.";
                } else {
                    echo "Lỗi: " . $conn->error;
                }
            } else {
                echo "Lỗi tải ảnh.";
            }
        }
    }
} else {
    echo "Sản phẩm không tồn tại.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="add_product.php">Thêm sản phẩm</a></li>
        </ul>
    </nav>

    <h2>Sửa sản phẩm</h2>

    <form action="update_product.php?id=<?php echo $product['id']; ?>" method="post" enctype="multipart/form-data">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo $product['name']; ?>" >
        
        <label for="price">Giá:</label>
        <input type="text" name="price" id="price" value="<?php echo $product['price']; ?>" >
        
        <label for="image">Ảnh sản phẩm:</label>
        <input type="file" name="image" id="image">
        <img src="uploads/<?php echo $product['image']; ?>" width="70" height="70"  alt="Ảnh cũ">
        
        <button type="submit">Cập nhật sản phẩm</button>
    </form>
</body>
</html>
