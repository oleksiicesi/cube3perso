<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_first_name = $_SESSION['user']['first_name'];
$user_last_name = $_SESSION['user']['last_name'];
$is_admin = $_SESSION['user']['is_admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="templates/style.css">
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <?php if ($is_admin): ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user_first_name . ' ' . $user_last_name); ?>!</h2>

        <?php if ($is_admin): ?>
            <p>This is your admin dashboard.</p>
        <?php else: ?>
            <p>This is your user dashboard.</p>
        <?php endif; ?>

        <?php include 'templates/footer.php'; ?>
</body>
</html>