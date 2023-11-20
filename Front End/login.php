<?php

include "../Back End/database.php";

global $db;

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    echo("<script>console.log('PHP: " . json_encode($username) . "');</script>");
    echo("<script>console.log('PHP: " . json_encode($password) . "');</script>");


    // Modify this part to use MySQL for authentication
    $query = "SELECT * FROM users WHERE username=? AND password=?;";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $db->close();
    $row=$result->fetch_assoc();
    echo("<script>console.log('PHP: " . json_encode($row) . "');</script>");

    if ($row) {
        $_SESSION["auth"] = 1;
        header("Location: success.php"); // Redirect to success page
    } else {
        header("Location: error.php"); // Redirect to error page
        exit();
    }


//    $sql = "SELECT * FROM users WHERE username = '$username'";
//    $result = mysqli_query($db, $sql);
//    echo("<script>console.log('PHP: ".json_encode($db)."');</script>");
//
//    if (mysqli_num_rows($result) == 1) {
//        $row = mysqli_fetch_assoc($result);
//        if (password_verify($password, $row['password'])) {
//            $_SESSION["auth"] = 1;
//            header("Location: success.php"); // Redirect to success page
//            exit();
//        }
//    }
//    header("Location: error.php"); // Redirect to error page
//    exit();
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
        <p>Haven't registered yet? <a href="registration.php">Register now</a></p>
    </div>
</form>
</body>
</html>