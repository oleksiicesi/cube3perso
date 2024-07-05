<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
if ($stmt->execute([$id])) {
    $_SESSION['message'] = 'User deleted successfully!';
} else {
    $_SESSION['message'] = 'User deletion failed!';
}

header('Location: admin.php');
exit();
?>
