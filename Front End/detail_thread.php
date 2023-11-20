<?php
session_start();

include "../Back End/database.php";

global $db;

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    // Check if the user is logged in
    if (isset($_GET['thread_id'])) {
        $thread_id = $_GET['thread_id'];

        $query = "SELECT thread_id, title, content, user_id FROM thread WHERE deleted_at IS NULL AND thread_id = ? AND user_id = ?;";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $thread_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($_SESSION['user_id'] == $row['user_id']) {
                $temp = $row;
                echo("<script>console.log('PHP1231231 " . json_encode($temp) . "');</script>");
            } else {
                echo "You don't have permission to delete this thread.";
            }
        } else {
            echo "Thread not found or already deleted.";
        }
    } else {
        echo "Thread ID not provided.";
    }
} else {
    echo "You are not authenticated.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Creating Thread...</title>
    <link rel="stylesheet" href="./static/create.css">
</head>
<body>
    <section class="create-thread">
    <h2>Edit Thread</h2>
        <form action="update_thread.php" method="POST">
<!--            <label for="thread-id">Thread Id:</label>-->
            <input type="hidden" id="thread-id" name="thread-id" value="<?php echo htmlspecialchars($temp['thread_id']); ?>" required>

            <label for="thread-title">Title:</label>
            <input type="text" id="thread-title" name="thread-title" value="<?php echo htmlspecialchars($temp['title']); ?>" required>

            <label for="thread-description">Description:</label>
            <textarea id="thread-description" name="thread-content" required><?php echo htmlspecialchars($temp['content']); ?></textarea>

            <input type="submit" value="Update Thread">
        </form>
    </section>
</body>
</html>