<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 1) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    $_SESSION['auth'] = 0;

    header("Location: login.php");
    exit();
}

$file_directory = "notes/";

$content = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save'])) {
    $content = $_POST['editor_content'];
    $noteId = md5($content);
    $dir_path = $file_directory . $noteId;
    $file_path = $dir_path . "/content.txt";

    if (!is_dir($dir_path)) {
        mkdir($dir_path);
    }
    
    if (file_put_contents($file_path, $content) !== false) {
        $save_message = "Content saved successfully. Note ID: $noteId";
    } else {
        $save_message = "Error saving content.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Note Saver</title>
    <style>
        body {
            background-color: rgba(0, 179, 255, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: flex-start; 
            align-items: center;
            height: 100vh;
            margin: 0;
            font-size: 24px;
        }
        
        .text-editor-container {
            flex-direction: column;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 24px;
        }

        .button:hover,
        .fixed-box .button:hover {
            background-color: #0057b3;
        }
        
        #editor_content {
            font-size: 28px;
        }
        
        .logout-button {
            position: absolute;
            right: 10px;
            background-color: red;
            color: white;
            cursor: pointer;
            border: none;
        }
        .logout-button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="logout-button">
        <form action="index.php" method="POST">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>
    </div>
    
    <h2>Text Editor</h2>
    <?php
    if (!empty($save_message)) {
        echo "<p>$save_message</p>";
    }
    ?>
    <form id="contentForm" action="index.php" method="POST">
        <div class="text-editor-container">
            <textarea name="editor_content" id="editor_content" rows="12" cols="110"><?php echo htmlspecialchars($content); ?></textarea>
             <div class="button-container">
                <button type="submit" name="save" value="Save" class="button">Save</button>
                <a href="content.php" target="_blank" class="button" style="text-decoration: none;">Open Saved Note</a>
            </div>
        </div>
    </form>
</body>
</html>
