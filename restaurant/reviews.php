<?php
require_once 'config.php';
session_start();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $rating = intval($_POST['rating']);
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

    if ($name && $rating >= 1 && $rating <= 5 && $comment) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reviews (customer_name, rating, comment) VALUES (?, ?, ?)");
            $stmt->execute([$name, $rating, $comment]);
            echo "<script>alert('Review submitted! It will be displayed after approval.'); window.location.href='/reviews.php';</script>";
        } catch (PDOException $e) {
            $error = "Error submitting review: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Please fill out all fields correctly.";
    }
}

// Fetch approved reviews
$stmt = $pdo->query("SELECT * FROM reviews WHERE approved = TRUE ORDER BY created_at DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Customer Reviews</h1>

        <!-- Review Submission Form -->
        <div class="max-w-lg mx-auto mb-12 bg-yellow-50 p-6 rounded-md">
            <h2 class="text-2xl font-semibold mb-4 text-center">Leave a Review</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <?php if (isset($error)): ?>
                    <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="name">Name</label>
                    <input type="text" id="name" name="name" class="w-full border rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="rating">Rating</label>
                    <select id="rating" name="rating" class="w-full border rounded-md p-2" required>
                        <option value="">Select rating</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="comment">Comment</label>
                    <textarea id="comment" name="comment" class="w-full border rounded-md p-2" rows="5" required></textarea>
                </div>
                <button type="submit" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500 w-full">Submit Review</button>
            </form>
        </div>

        <!-- Approved Reviews -->
        <h2 class="text-2xl font-semibold mb-6 text-center">What Our Customers Say</h2>
        <?php if (count($reviews) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($reviews as $review): ?>
                    <div class="bg-white shadow-md rounded-md p-6">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($review['customer_name']); ?></h3>
                        <p class="text-yellow-400 mt-1">
                            <?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?>
                        </p>
                        <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($review['comment']); ?></p>
                        <p class="text-sm text-gray-500 mt-2"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No reviews yet. Be the first to share your experience!</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'footer.php'; ?>