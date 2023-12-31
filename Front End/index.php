<!DOCTYPE html>
<html lang="en">
<head>
    <title>ConnectThread</title>
    <link rel="stylesheet" href="./static/index.css">
</head>
<body>
<header>
    <div class="top-header">
        <h1>🅒🅞🅝🅝🅔🅒🅣🅣🅗🅡🅔🅐🅓</h1>
        <div class="header-buttons">
            <?php

            session_start();
            if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>
                            <a href="registration.php">Register</a>';
                }

            ?>
        </div>
    </div>
</header>
<main>
    <section class="intro">
        <div class="intro-content">
            <div class="intro-text">
                <h2>Join the Conversation</h2>
                <p>ConnectThread is a social discussion hub where you can discuss a wide range of topics, create
                    threads, and interact with others.</p>
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
            error_reporting(0);
            include "../Back End/database.php";

            global $db;

            $query = "SELECT thread_id, title, content, username FROM thread JOIN users ON thread.user_id = users.id WHERE deleted_at IS NULL;";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
//                    echo("<script>console.log('PHP: " . json_encode($row) . "');</script>");
                    echo '<div class="thread">';
                    echo '<div class="thread-info">';
                    echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
                    echo '<p>' . htmlspecialchars($row["username"]) . '</p>';
                    echo '</div>';
                    echo '<p>' . htmlspecialchars($row["content"]) . '</p>';
                    if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
                        if ($_SESSION['username'] == $row['username']) {
                            echo '<a class="edit-button" href="./delete_thread.php?thread_id=' . $row['thread_id'] . '">DELETE</a>';
                            echo '<a class="delete-button" href="detail_thread.php?thread_id=' . $row['thread_id'] . '">EDIT</a>';
                        }
                    }
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