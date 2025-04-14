<?php
include 'db.php';
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
header('Content-Type: application/json');
echo json_encode($products);
?>
    