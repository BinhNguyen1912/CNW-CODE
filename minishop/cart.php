<?php
include 'includes/header.php';
include 'config/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

$total = 0;
?>

<h3>Giỏ hàng của bạn</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
    </tr>
    <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
        <?php
        $res = $conn->query("SELECT * FROM products WHERE id = $id");
        $prod = $res->fetch_assoc();
        $line = $prod['price'] * $qty;
        $total += $line;
        ?>
        <tr>
            <td><?= htmlspecialchars($prod['name']) ?></td>
            <td><?= $qty ?></td>
            <td><?= number_format($line) ?> VNĐ</td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2">Tổng cộng</td>
        <td><strong><?= number_format($total) ?> VNĐ</strong></td>
    </tr>
</table>
</body>
</html>
