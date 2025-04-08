<?php
require_once 'db.php';
require_once 'auth.php';

// Require login
requireLogin();

// Fetch all moods
$stmt = $pdo->query("SELECT * FROM moods ORDER BY mood_name");
$moods = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch movies based on selected mood
$selectedMood = isset($_GET['mood']) ? $_GET['mood'] : null;
if ($selectedMood) {
    $stmt = $pdo->prepare("SELECT movies.* FROM movies 
                          JOIN moods ON movies.mood_id = moods.id 
                          WHERE moods.mood_name = ?");
    $stmt->execute([$selectedMood]);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Mood Matcher</title>
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
        <section class="mood-selector">
            <h2>How are you feeling today?</h2>
            <form id="moodForm" method="GET">
                <div class="mood-options">
                    <?php foreach ($moods as $mood): ?>
                    <div class="mood-option">
                        <input type="radio" 
                               name="mood" 
                               id="<?php echo htmlspecialchars($mood['mood_name']); ?>" 
                               value="<?php echo htmlspecialchars($mood['mood_name']); ?>"
                               <?php echo ($selectedMood === $mood['mood_name']) ? 'checked' : ''; ?>>
                        <label for="<?php echo htmlspecialchars($mood['mood_name']); ?>">
                            <?php echo htmlspecialchars($mood['mood_name']); ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit">Find Movies</button>
            </form>
        </section>

        <?php if (isset($selectedMood) && isset($movies)): ?>
        <section class="movie-results">
            <h2>Movies for <?php echo htmlspecialchars($selectedMood); ?> Mood</h2>
            <div class="movie-grid">
                <?php if (empty($movies)): ?>
                    <p class="no-movies">No movies found for this mood. Why not <a href="add_movie.php">add one</a>?</p>
                <?php else: ?>
                    <?php foreach ($movies as $movie): ?>
                    <div class="movie-card">
                        <img src="<?php echo htmlspecialchars($movie['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='default.jpg'">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <p><?php echo htmlspecialchars($movie['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Movie Mood Matcher. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html> 