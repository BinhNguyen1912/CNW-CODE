<?php
//dua header vao ne
include 'includes/header.php';
include 'config/db.php';

$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>

<h3>Danh sách sản phẩm</h3>
<div style="display: flex; flex-wrap: wrap;">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px; width: 200px;">
            <img src="uploads/<?= $row['image'] ?>" width="100%" height="150">
            <h4><?= htmlspecialchars($row['name']) ?></h4>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <p><strong><?= number_format($row['price']) ?> VNĐ</strong></p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit">Thêm vào giỏ</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
