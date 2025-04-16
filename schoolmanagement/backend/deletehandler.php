<?php
require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    try {
        $stmt->execute([$id]);
        header("Location: ../frontend/view.php?message=deleted");
        exit();
    } catch (PDOException $e) {
        echo "Error deleting student: " . $e->getMessage();
    }
} else {
    echo "No ID provided.";
}
?>
