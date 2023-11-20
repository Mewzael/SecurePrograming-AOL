<?php
session_start();


include "../Back End/database.php";

global $db;

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    // Check if the user is logged in
    if (isset($_GET['thread_id'])) {
        $thread_id = $_GET['thread_id'];


        $query = "SELECT thread_id, user_id FROM thread WHERE deleted_at IS NULL AND thread_id = ? AND user_id = ?;";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $thread_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($_SESSION['user_id'] == $row['user_id']) {
                // Delete the thread
                $deleteQuery = "UPDATE thread SET deleted_at = NOW() WHERE thread_id = ?;";
                $deleteStmt = $db->prepare($deleteQuery);
                $deleteStmt->bind_param("i", $thread_id);
                $deleteStmt->execute();

                header("Location: index.php");
                exit();
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