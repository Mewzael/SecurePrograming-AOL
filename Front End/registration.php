<?php

include "../Back End/database.php";

global $db;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

// Perform input validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        header("Location: registration.php?error=empty_fields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registration.php?error=invalid_email");
        exit();
    }

    if ($password != $confirmPassword) {
        header("Location: registration.php?error=password_mismatch");
        exit();
    }

// Hash the password (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database using prepared statements
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: registration.php?success=registered");
    } else {
        $error_message = "Database error: " . $stmt->error;

        error_log($error_message, 0);

        header("Location: registration.php?error=registration_failed&message=" . urlencode($error_message));
    }

    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./static/register.css">
    <title>ConnectThread - Register</title>
</head>
<body>
<form class="register-page" action="registration.php" method="post">
    <h2>Register for ConnectThread</h2>
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter a username" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>
    </div>
    <div>
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password"
               required>
    </div>
    <div>
        <input type="submit" value="Register">
    </div>
    <div class="login-link">
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </div>
</form>
</body>
</html>
