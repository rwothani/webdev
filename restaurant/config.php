<!-- <?php
// $host = 'localhost';
// $dbname = 'palace_restaurant'; // change this to match your actual database name
// $user = 'root';
// $pass = ''; // or your MySQL password

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
//     // Set error mode to exception
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }
?> -->
<?php
$host = 'localhost';
$dbname = 'palace_restaurant';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create admins table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )
    ");

    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = ?");
    $stmt->execute(['admin']);
    $adminExists = $stmt->fetchColumn();

    // If no admin exists, create one
    if ($adminExists == 0) {
        $defaultUsername = 'admin';
        $defaultPassword = 'password123'; // Default password
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->execute([$defaultUsername, $hashedPassword]);
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>