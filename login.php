<?php
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === "admin" && $password === "admin123") {
        $_SESSION["auth"] = 1;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
     <style>
        body {
            background-image: url(https://wallpapers.com/images/hd/notebook-paper-background-d2f8l42mf0ixfo90.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            font-family: Arial, sans-serif;
            color: #333; /* Header text color */
            text-align: center;
        }

        form {
            background-color: #fff; /* Background color for the form */
            border-radius: 20px; /* Rounded corners for the form */
            box-shadow: 0 10 10px rgba(0, 0, 0, 0.2); /* Drop shadow for the form */
            width: 300px; /* Width of the form */
            margin: 0 auto; /* Center-align the form */
            padding: 30px; /* Add padding to the form */
        }

        input[type="text"],
        input[type="password"] {
            font-family: Arial, sans-serif;
            width: 80%; /* Make text inputs full-width within the form */
            padding: 10px; /* Add padding to text inputs */
            margin-bottom: 20px; /* Add spacing between inputs */
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            font-family: Arial, sans-serif;
            background-color: #0073e6; /* Background color for the login button */
            color: #fff; /* Text color for the login button */
            border: none; /* Remove button border */
            border-radius: 5px; /* Rounded corners for the login button */
            padding: 10px 20px; /* Add padding to the login button */
            cursor: pointer; /* Add a pointer cursor on hover */
        }

        button[type="submit"]:hover {
            background-color: #0057b3; /* Background color on hover */
        }

        .error-message {
            font-family: Arial, sans-serif;
            color: #ff0000; /* Error message text color */
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
<!--
Just in case I Forgot
admin
admin123
-->
</body>
</html>
