<?php
include('db.php');

// Biến để lưu thông báo lỗi và thông tin nhập
$nameErr = $priceErr = $imageErr = "";
$name = $price = $image = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isValid = true;
    
    // Kiểm tra tên sản phẩm
    if (empty($_POST['name'])) {
        $nameErr = "Tên sản phẩm không được để trống.";
        $isValid = false;
    } else {
        $name = $_POST['name'];
    }
    
    // Kiểm tra giá sản phẩm
    if (empty($_POST['price'])) {
        $priceErr = "Giá sản phẩm không được để trống.";
        $isValid = false;
    } elseif (!is_numeric($_POST['price'])) {
        $priceErr = "Giá sản phẩm phải là một số.";
        $isValid = false;
    } else {
        $price = $_POST['price'];
    }
    
    // Kiểm tra ảnh
    if (empty($_FILES['image']['name'])) {
        $imageErr = "Ảnh sản phẩm không được để trống.";
        $isValid = false;
    } else {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        
        // Kiểm tra việc tải ảnh lên
        if ($_FILES['image']['error'] == 0) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imageErr = "Lỗi tải ảnh lên.";
                $isValid = false;
            }
        }
    }
    
    // Nếu tất cả các trường hợp hợp lệ, thêm sản phẩm vào cơ sở dữ liệu
    if ($isValid) {
        $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Sản phẩm đã được thêm thành công.";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="add_product.php">Thêm sản phẩm</a></li>
        </ul>
    </nav>

    <h2>Thêm sản phẩm mới</h2>

    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>" >
        <span class="error"><?php echo $nameErr; ?></span>
        
        <label for="price">Giá:</label>
        <input type="text" name="price" id="price" value="<?php echo $price; ?>" >
        <span class="error"><?php echo $priceErr; ?></span>
        
        <label for="image">Ảnh sản phẩm:</label>
        <input type="file" name="image" id="image" >
        <span class="error"><?php echo $imageErr; ?></span>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</body>
</html>
