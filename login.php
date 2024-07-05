<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
    } else {
        
        $_SESSION['message'] = 'Invalid email or password. Please try again.';
    }
}
?>
<?php include 'templates/header.php'; ?>
<div class="container">
    <h2>Login</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="flash"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</div>
<?php include 'templates/footer.php'; ?>
