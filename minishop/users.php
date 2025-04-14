<?php
require 'config/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$users = [];

$stmt = $conn->prepare("SELECT id, username, role, address FROM users");


if (!$stmt) {
    die("Lỗi truy vấn: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>


<h2>Quản lý người dùng</h2>

<a href="add_user.php">+ Thêm người dùng mới</a>
<br><br>


<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Vai trò</th>
        <th>Địa chỉ</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= $user['role'] ?></td>
            <td><?= htmlspecialchars($user['address']) ?></td>
            <td>
                <?php if ($_SESSION['user']['id'] !== $user['id']): ?>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Xóa người dùng này?')">Xóa</a> |
                    <a href="edit_user.php?id=<?= $user['id'] ?>">Sửa</a>
                <?php else: ?>
                    (Bạn)
                <?php endif; ?>
                

            </td>

        </tr>
    <?php endforeach; ?>
</table>
