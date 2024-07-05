<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user'])) {
    
    echo "User session not set, redirecting to login.";
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        session_destroy();
        header("Location: register.php");
        exit;
    } else {
        
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET email = ?, first_name = ?, last_name = ?, password = ? WHERE id = ?");
        $stmt->execute([$email, $first_name, $last_name, $password_hash, $user_id]);

        $_SESSION['flash_message'] = "Profile updated successfully!";
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['first_name'] = $first_name;
        $_SESSION['user']['last_name'] = $last_name;

        header("Location: profile.php");
        exit;
    }
}


$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="templates/style.css">
    <style>

        .container form:first-of-type button[type="submit"] {
            background-color: #87CEEB; 
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px; 
        }

        .container form:first-of-type button[type="submit"]:hover {
            background-color: #0056b3; 
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete your account? This action cannot be undone.');
        }
    </script>
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2>Edit Profile</h2>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash">
                <?php echo $_SESSION['flash_message']; ?>
                <?php unset($_SESSION['flash_message']); ?>
            </div>
        <?php endif; ?>

        <form action="profile.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Update Profile</button>
        </form>

        <form action="profile.php" method="POST" onsubmit="return confirmDelete();">
            <input type="hidden" name="delete" value="1">
            <input type="submit" class="delete-button" value="Delete Account">
        </form>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
