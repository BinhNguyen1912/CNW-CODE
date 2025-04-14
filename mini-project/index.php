<?php
session_start();
include 'config/db.php';

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

?>

<h2>Chào mừng, <?= htmlspecialchars($_SESSION['user_id']) ?>!</h2>
<p><a href="logout.php">Đăng xuất</a></p>

<hr>

<?php if ($_SESSION['user_role'] === 'admin'): ?>
    <h3>Quản lý người dùng</h3>
    <p><a href="manage_users.php">Quản lý người dùng</a></p>
<?php endif; ?>

<hr>
<h3>Danh sách sản phẩm</h3>

<?php
// Lấy tất cả sản phẩm từ database
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= number_format($row['price'], 0, ',', '.') ?> VNĐ</td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="80">
                    <?php else: ?>
                        Không có ảnh
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Chưa có sản phẩm nào.</p>
<?php endif; ?>
