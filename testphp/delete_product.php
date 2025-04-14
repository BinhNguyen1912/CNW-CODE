<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Xóa sản phẩm khỏi cơ sở dữ liệu
    $sql = "DELETE FROM products WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Sản phẩm đã được xóa.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
header("Location: index.php");
exit();
?>
