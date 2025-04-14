<?php
session_start();
session_unset(); // Xóa toàn bộ session
session_destroy(); // Hủy session

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit;
?>