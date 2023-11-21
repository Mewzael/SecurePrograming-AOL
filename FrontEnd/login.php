<?php
// error_reporting(0);
include "../BackEnd/database.php";

global $db;

session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    header("Location: ./index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT password, attempt, last_login_time, id, username FROM users WHERE username=?;";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $dbTimestamp = strtotime($row['last_login_time']);
        $currentTimestamp = time();
        $timeDifference = ($currentTimestamp - $dbTimestamp + 21600);

        if ($row['attempt'] < 3 || $timeDifference >= 60) {
            if ($row && password_verify($password, $row["password"])) {
                $_SESSION["auth"] = 1;
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $query = "UPDATE users SET attempt = 0, last_login_time = CURRENT_TIMESTAMP WHERE username = ?;";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                header("Location: ./index.php");
            } else {
                $row["attempt"] = $row["attempt"] + 1;
                $query = "UPDATE users SET attempt = ?, last_login_time = CURRENT_TIMESTAMP WHERE username = ?;";
                $stmt = $db->prepare($query);
                $stmt->bind_param("is", $row['attempt'], $username);
                $stmt->execute();
                echo '<script>alert(\'Wrong username or password\')</script>';
            }
        } else if ($row['attempt'] >= 3 && $timeDifference < 60) {
            echo '<script>alert(\'Too many login attempts. Please try again later\')</script>';
        }
    } else {
        echo '<script>alert(\'Wrong username or password\')</script>';
    }
    $db->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./static/login.css">
    <title>ConnectThread</title>
</head>
<body>
<form class="login-page" action="./login.php" method="post">
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
        <p>Haven't registered yet? <a href="./registration.php">Register now</a></p>
    </div>
</form>
</body>
</html>