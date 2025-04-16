<?php
// php/admin/add_item.php
require_once('database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Grab data from form
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $category = htmlspecialchars(trim($_POST['category']));

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imgName = $_FILES['image']['name'];
        $imgTmp = $_FILES['image']['tmp_name'];
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imgExt, $allowed)) {
            $newName = uniqid("img_", true) . '.' . $imgExt;
            $uploadPath = 'images/' . $newName;

            if (move_uploaded_file($imgTmp, $uploadPath)) {
                // Insert into DB
                $sql = "INSERT INTO menu (name, description, price, image, category)
                        VALUES (:name, :description, :price, :image, :category)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':image' => $newName,
                    ':category' => $category
                ]);

                header("Location: admin.php?success=1");
                exit();
            } else {
                die("Failed to upload image.");
            }
        } else {
            die("Only JPG, PNG, JPEG, and GIF files are allowed.");
        }
    } else {
        die("Image upload failed.");
    }
} else {
    die("Invalid request.");
}
?>
