<link rel="stylesheet" href="style.css">

<?php
include 'includes/auth.php';
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");
header("Location: index.php");
?>
