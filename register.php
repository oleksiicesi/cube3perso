<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_pattern = "/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/";

    if (!preg_match($password_pattern, $password)) {
        $error_message = "Password must be at least 8 characters long and include at least one number and one special character.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $password_hash]);

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            const password = document.getElementById("password").value;
            const pattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
            if (!pattern.test(password)) {
                alert("Password must be at least 8 characters long and include at least one number and one special character.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error_message)): ?>
            <div class="flash"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST" onsubmit="return validateForm();">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
