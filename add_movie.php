<?php
require_once 'db.php';
require_once 'auth.php';

// Require login
requireLogin();

$message = '';
$messageType = '';

// Fetch all moods for the dropdown
$stmt = $pdo->query("SELECT * FROM moods ORDER BY mood_name");
$moods = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $moodId = $_POST['mood_id'] ?? '';
    $imageUrl = trim($_POST['image_url'] ?? '');

    // Validate input
    if (empty($title) || empty($description) || empty($moodId)) {
        $message = "Please fill in all required fields.";
        $messageType = "error";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO movies (title, description, mood_id, image_url, user_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $moodId, $imageUrl, $_SESSION['user_id']]);
            $message = "Movie added successfully!";
            $messageType = "success";
        } catch (PDOException $e) {
            $message = "Error adding movie: " . $e->getMessage();
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie - Movie Mood Matcher</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Movie Mood Matcher</div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_movie.php">Add Movie</a></li>
                <li>
                    <span class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="add-movie-form">
            <h2>Add New Movie</h2>
            <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <form id="addMovieForm" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="title">Movie Title*</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="mood_id">Mood*</label>
                    <select id="mood_id" name="mood_id" required>
                        <option value="">Select a mood</option>
                        <?php foreach ($moods as $mood): ?>
                        <option value="<?php echo $mood['id']; ?>">
                            <?php echo htmlspecialchars($mood['mood_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="url" id="image_url" name="image_url" placeholder="https://example.com/image.jpg">
                </div>

                <button type="submit">Add Movie</button>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html> 