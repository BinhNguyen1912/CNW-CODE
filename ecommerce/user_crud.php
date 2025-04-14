<link rel="stylesheet" href="style.css">
<?php
include 'includes/auth.php'; include 'db.php';

$edit_id = $_GET['edit'] ?? null;
$edit_user = null;

if ($edit_id) {
    $res = $conn->query("SELECT * FROM users WHERE id=$edit_id");
    $edit_user = $res->fetch_assoc();
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

<form action="user_action.php" style="width: 90%;" method="POST">
    <input type="hidden" name="id" value="<?= $edit_user['id'] ?? '' ?>">

    <label>Tên đăng nhập:</label>
    <input type="text" name="username" required value="<?= $edit_user['username'] ?? '' ?>">

    <label>Mật khẩu:</label>
    <input type="text" name="password" required value="<?= $edit_user['password'] ?? '' ?>">

    <label>Địa chỉ:</label>
    <input type="text" name="address" required value="<?= $edit_user['address'] ?? '' ?>">

    <label>Điện thoại:</label>
    <input type="text" name="phone" required value="<?= $edit_user['phone'] ?? '' ?>">

    <button type="submit"><?= $edit_user ? 'Cập nhật' : 'Thêm mới' ?></button>
</form>

<hr>

<h3>Danh sách người dùng</h3>
<table border="1" cellpadding="10">
    <tr><th>ID</th><th>Tên đăng nhập</th><th>Địa chỉ</th><th>SDT</th><th>Hành động</th></tr>
    <?php
    $users = $conn->query("SELECT * FROM users");
    while ($row = $users->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['address']}</td>
            <td>{$row['phone']}</td>
            <td>
                <a href='user_crud.php?edit={$row['id']}'>Sửa</a> | 
                <a href='user_action.php?delete={$row['id']}' onclick=\"return confirm('Xóa user này?')\">Xóa</a>
            </td>
        </tr>";
    }
    ?>
</table>