<?php
require 'db.php';

$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    header("Location: admin.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, is_admin = ? WHERE id = ?");
    $stmt->execute([$first_name, $last_name, $email, $password, $is_admin, $user_id]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="templates/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Edit User</h2>
        <form action="edit_user.php?id=<?php echo htmlspecialchars($user_id); ?>" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br>
            <label for="is_admin">Admin:</label>
            <input type="checkbox" id="is_admin" name="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
            <br>
            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>
<?php include 'templates/footer.php'; ?>
