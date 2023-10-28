<?php
include "../../Back End/database.php";
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../static/login.css">
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
            <p>Haven't registered yet? <a href="registration.html">Register now</a></p>
        </div>
    </form>
</body>
</html>


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Modify this part to use MySQL for authentication
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION["auth"] = 1;
            header("Location: success.php"); // Redirect to success page
            exit();
        }
    }
    header("Location: error.php"); // Redirect to error page
    exit();
}
?>