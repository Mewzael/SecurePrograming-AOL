<?php

include "../Back End/database.php";

global $db;

session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username=?;";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $db->close();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row["password"])) {
        $_SESSION["auth"] = 1;
        $_SESSION["user_id"] = $row["id"];
        echo("<script>console.log('PHP: " . json_encode($_SESSION) . "');</script>");
        header("Location: create_thread.php"); // Redirect to success page
    } else {
        header("Location: error.php"); // Redirect to error page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./static/login.css">
    <title>ConnectThread</title>
</head>
<body>
<form class="login-page" action="login.php" method="post">
    <h2>Welcome to ConnectThread!</h2>
    <div>
        <label for="username">Username:</label>
        <input type="text" placeholder="Enter your username" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" placeholder="Enter your password" id="password" name="password" required>
    </div>
    <div>
        <input type="submit" value="Login">
    </div>
    <div class="register-link">
        <p>Haven't registered yet? <a href="registration.php">Register now</a></p>
    </div>
</form>
</body>
</html>