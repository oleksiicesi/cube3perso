<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="templates/style.css">
</head>
<body>
<nav>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <?php if ($_SESSION['user']['is_admin']): ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
        <?php if (!$_SESSION['user']['is_admin']): ?>
            <a href="profile.php">Profile</a>
            <?php endif; ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>
<div class="container">