<?php
require 'database.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare the SQL insert statement
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");

    try {
        // Execute the statement with user input
        $stmt->execute([$name, $email, $message]);

        // Redirect to the contact page with a success message
        header("Location: ../contact.php?message=sent");
        exit();

    } catch (PDOException $e) {
        echo "Error sending message: " . $e->getMessage();
    }
}
?>
