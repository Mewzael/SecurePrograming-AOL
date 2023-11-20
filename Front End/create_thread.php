<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $threadTitle = $_POST["thread-title"];
    $threadDescription = $_POST["thread-description"];
    $author = "User123"; // You may replace this with the actual username of the logged-in user

    // TODO: Insert data into the database (use prepared statements for security)
    // Example: INSERT INTO threads (title, description, author) VALUES ('$threadTitle', '$threadDescription', '$author')
    
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
        <textarea id="thread-description" name="thread-description" required></textarea>

        <input type="submit" value="Create Thread">
    </form>
</section>
