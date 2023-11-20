<?php

include "../Back End/database.php";

global $db;

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    // Get data from the form
    $threadTitle = $_POST["thread-title"];
    $threadContent = $_POST["thread-content"];
    $author = $_SESSION["user_id"];; // You may replace this with the actual username of the logged-in user
    $date = date("Y-m-d H:i:s");

    // TODO: Insert data into the database (use prepared statements for security)
    // Example: INSERT INTO threads (title, description, author) VALUES ('$threadTitle', '$threadDescription', '$author')
    $sql = "INSERT INTO thread (title, content, user_id, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssss", $threadTitle, $threadContent, $author, $date);

    if ($stmt->execute()) {
        header("Location: registration.php?success=registered");
    } else {
        $error_message = "Database error: " . $stmt->error;

        error_log($error_message, 0);

        header("Location: registration.php?error=registration_failed&message=" . urlencode($error_message));
    }

    $stmt->close();
    $db->close();
    // After inserting, you may redirect the user back to the forum page or display a success message
    header("Location: forum.php");
    exit();
}
?>

<section class="create-thread">
    <h2>Create a New Thread</h2>
    <form action="create_thread.php" method="post">
        <label for="thread-title">Title:</label>
        <input type="text" id="thread-title" name="thread-title" required>

        <label for="thread-description">Description:</label>
        <textarea id="thread-description" name="thread-content" required></textarea>

        <input type="submit" value="Create Thread">
    </form>
</section>
