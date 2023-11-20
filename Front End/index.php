<!DOCTYPE html>
<html>
<head>
    <title>ConnectThread</title>
    <link rel="stylesheet" href="/static/index.css">
</head>
<body>
    <header>
        <div class="top-header">
            <h1>🅒🅞🅝🅝🅔🅒🅣🅣🅗🅡🅔🅐🅓</h1>
            <div class="header-buttons">
                <a href="login.php">Login</a>
                <a href="registration.php">Register</a>
            </div>
        </div>
    </header>
    <main>
        <section class="intro">
            <div class="intro-content">
                <div class="intro-text">
                    <h2>Join the Conversation</h2>
                    <p>ConnectThread is a social discussion hub where you can discuss a wide range of topics, create threads, and interact with others.</p>
                </div>
            <a href="create_thread.php" class="create-thread-button">Create Thread</a>
            </div>
        </section>
        <section class="features">
            <h3>Key Features</h3>
            <ul>
                <li>Discussion Threads</li>
                <li>User-Friendly Interface</li>
                <li>Join the Community</li>
            </ul>
        </section>
        <section class="forum">
            <div class="forum-title">
                <h2>Main Discussion Thread</h2>
            </div>
            <div class="forum-box">
                <?php

                include "../Back End/database.php";

                global $db;

                $query = "SELECT title, content, username FROM thread JOIN users ON thread.user_id = users.id WHERE deleted_at IS NULL;";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo("<script>console.log('PHP: " . json_encode($row) . "');</script>");
                        echo '<div class="thread">';
                        echo '<div class="thread-info">';
                        echo '<h3>' . $row["title"] . '</h3>';
                        echo '<p>' . $row["username"] . '</p>';
                        echo '</div>';
                        echo '<p>' . $row["content"] . '</p>';
                        echo '</div>';
                    }
                }

                $db->close();
                ?>
        </div>
    </section>
    </main>
    <footer>
        <p>&copy; 2023 ConnectThread</p>
    </footer>
</body>
</html>