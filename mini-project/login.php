<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

$username = $password = '';
$errors = [];

// Nếu user đã login thì chuyển hướng
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Nếu user đã chọn ghi nhớ => tự động đăng nhập lại
if (isset($_COOKIE['remember_username']) && isset($_COOKIE['remember_password'])) {
    $username = $_COOKIE['remember_username'];
    $password = $_COOKIE['remember_password'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $_SESSION['user_id'] = $username;
        header("Location: index.php");
        exit;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate
    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập";
    }

    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password); // KHÔNG hash password
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $username;

            if (isset($_POST['remember'])) {
                setcookie('remember_username', $username, time() + 7 * 24 * 3600);
                setcookie('remember_password', $password, time() + 7 * 24 * 3600);
            }

            header("Location: index.php");
            exit;
        } else {
            $errors['general'] = "Tên đăng nhập hoặc mật khẩu không đúng";
        }
        $stmt->close();
    }
}
?>

<h2>Đăng nhập</h2>
<?php if (!empty($errors['general'])): ?>
    <div class="error"><?= $errors['general'] ?></div>
<?php endif; ?>

<form method="POST">
    <label>Tên đăng nhập:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
    <?php if (!empty($errors['username'])): ?>
        <div class="error"><?= $errors['username'] ?></div>
    <?php endif; ?>

    <label>Mật khẩu:</label>
    <input type="password" name="password">
    <?php if (!empty($errors['password'])): ?>
        <div class="error"><?= $errors['password'] ?></div>
    <?php endif; ?>

    <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>

    <button type="submit">Đăng nhập</button>
</form>

