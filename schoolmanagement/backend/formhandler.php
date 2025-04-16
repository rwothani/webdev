<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $course = $_POST['course'];
    $reg_no = $_POST['reg_no'];

    $sql = "INSERT INTO students (name, age, sex, course, reg_no) 
            VALUES (:name, :age, :sex, :course, :reg_no)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name' => $name,
            ':age' => $age,
            ':sex' => $sex,
            ':course' => $course,
            ':reg_no' => $reg_no
        ]);
        header("Location: ../frontend/view.php?message=success");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
