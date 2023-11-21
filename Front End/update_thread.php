<?php
session_start();
error_reporting(0);
include "../Back End/database.php";

global $db;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    $threadTitle = $_POST["thread-title"];
    $threadContent = $_POST["thread-content"];
    $threadId = (int)$_POST["thread-id"];

    if (isset($threadId)) {
        $query = "SELECT thread_id, title, content, user_id FROM thread WHERE deleted_at IS NULL AND thread_id = ? AND user_id = ?;";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $threadId, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $updateQuery = "UPDATE thread SET title = ?, content = ? WHERE thread_id = ? AND user_id = ?;";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bind_param("ssii", $threadTitle, $threadContent, $threadId, $_SESSION['user_id']);
            $updateStmt->execute();
        } else {
            echo '<script>alert(\'Thread not found or Unauthorized.\'); window.location.href="index.php"</script>';
        }
    } else {
        echo '<script>alert(\'Thread not found or Unauthorized.\'); window.location.href="index.php"</script>';
    }

    $db->close();
    header("Location: index.php");
} else {
    echo "You are not authenticated.";
}

?>
