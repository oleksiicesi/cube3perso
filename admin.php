<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT id, first_name, last_name, email, is_admin FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="templates/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                            <?php if (!$user['is_admin']): ?>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    
        <?php if ($_SESSION['user']['is_admin']): ?>
            <a href="create_user.php">Create User</a>
        <?php endif; ?>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
