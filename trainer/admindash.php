<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DashBorad</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <h1>📚 Admin Dashboard</h1>
    <div class="card">
        <h2>Borrowed Programming Books</h2>
        <ul>
            <?php
    $stmt = $pdo->query("SELECT title FROM books WHERE status = 'borrowed'");
    foreach ($stmt as $row) {
        echo "<li>" . htmlspecialchars($row['title']) . "</li>";
    }
    ?>
        </ul>
    </div>

    <div class="card">
        <h2>Returned Books</h2>
        <ul>
            <?php
    $stmt = $pdo->query("SELECT title FROM books WHERE status = 'returned'");
    foreach ($stmt as $row) {
        echo "<li>" . htmlspecialchars($row['title']) . "</li>";
    }
    ?>
        </ul>
    </div>

    <div class="card">
        <h2>Registered Users</h2>
        <ul>
            <?php
    $stmt = $pdo->query("SELECT username FROM users");
    foreach ($stmt as $row) {
        echo "<li>" . htmlspecialchars($row['username']) . "</li>";
    }
    ?>
        </ul>
    </div>

    <div class="card">
        <h2>Punished Users</h2>
        <ul>
            <?php
    $stmt = $pdo->query("SELECT u.username FROM users u JOIN books b ON u.id = b.borrowed_by WHERE DATEDIFF(CURDATE(), b.borrowed_on) > 30 AND b.returned_on IS NULL GROUP BY u.username");
    foreach ($stmt as $row) {
        echo "<li>" . htmlspecialchars($row['username']) . "</li>";
    }
    ?>
        </ul>
    </div>

</body>

</html>