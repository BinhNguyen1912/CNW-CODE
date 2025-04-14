<?php
session_start();

// Xóa session
session_unset();
session_destroy();

// Xóa cookie nếu có
setcookie('remember_username', '', time() - 3600, '/');
setcookie('remember_password', '', time() - 3600, '/');

// Chuyển hướng về trang đăng nhập
header('Location: login.php');
exit;
?>
