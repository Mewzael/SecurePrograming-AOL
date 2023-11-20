<?php
session_start();

include "../Back End/database.php";

global $db;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    $threadTitle = $_POST["thread-title"];
    $threadContent = $_POST["thread-content"];
    $threadId = (int)$_POST["thread-id"];

    $updateQuery = "UPDATE thread SET title = ?, content = ? WHERE thread_id = ? AND user_id = ?;";
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bind_param("ssii", $threadTitle, $threadContent, $threadId, $_SESSION['user_id']);
    $updateStmt->execute();

    header("Location: index.php");
}

?>
