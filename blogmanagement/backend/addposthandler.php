<?php
require '../backend/database.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare the SQL insert statement
    $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");

    try {
        // Execute the statement with user input
        $stmt->execute([$title, $content]);

        // Redirect to the home page with a success message
        header("Location: ../index.php?message=post_added");
        exit();

    } catch (PDOException $e) {
        echo "Error adding post: " . $e->getMessage();
    }
}
?>
