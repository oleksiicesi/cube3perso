<?php


$host = 'localhost'; 
$db   = 'cube3_personnel'; 
$user = 'root';       
$pass = 'mysql';           
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

function initializeDatabase($pdo) {

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_admin BOOLEAN DEFAULT FALSE,
	    first_name VARCHAR(255) NOT NULL,
	    last_name VARCHAR(255) NOT NULL
    )");


    $adminUsers = [
        [
            'email' => 'admin@healthplus.com',
            'password' => password_hash('admin1409!', PASSWORD_DEFAULT),
            'first_name' => 'Adam',
            'last_name' => 'Smith'
        ],
    ];

    foreach ($adminUsers as $admin) {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$admin['email']]);
        if ($stmt->fetch() === false) {

            $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, is_admin) VALUES (?, ?, ?, ?, 1)");
            $stmt->execute([$admin['email'], $admin['password'], $admin['first_name'], $admin['last_name']]);
        }
    }
}

initializeDatabase($pdo);
?>
