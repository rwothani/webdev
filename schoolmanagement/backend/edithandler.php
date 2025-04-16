<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $age    = $_POST['age'];
    $sex    = $_POST['sex'];
    $course = $_POST['course'];
    $reg_no = $_POST['reg_no'];

    $sql = "UPDATE students SET 
                name = :name, 
                age = :age, 
                sex = :sex, 
                course = :course, 
                reg_no = :reg_no 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':id'     => $id,
            ':name'   => $name,
            ':age'    => $age,
            ':sex'    => $sex,
            ':course' => $course,
            ':reg_no' => $reg_no
        ]);
        header("Location: ../frontend/view.php?message=updated");
        exit();
    } catch (PDOException $e) {
        echo "Error updating student: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
