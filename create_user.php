<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, is_admin) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $email, $password, $is_admin]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="templates/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Create User</h2>
        <form action="create_user.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="is_admin">Admin:</label>
            <input type="checkbox" id="is_admin" name="is_admin">
            <br>
            <button type="submit">Create User</button>
        </form>
    </div>
</body>
</html>
<?php include 'templates/footer.php'; ?>
