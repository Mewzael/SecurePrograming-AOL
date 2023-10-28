<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 1) {
    header("Location: login.php");
    exit();
}

$file_directory = "notes/";

$searchResults = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {
    $searchTerm = $_POST['search_term'];
    $searchResults = searchNotes($searchTerm);
}

function searchNotes($searchTerm) {
    $results = [];
    $notesDirectory = "notes/";
    
    if (is_dir($notesDirectory)) {
        $files = scandir($notesDirectory);
        
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && is_dir($notesDirectory . $file)) {
                if (stripos($file, $searchTerm) !== false) {
                    $dir_path = $notesDirectory . $file;
                    $contentPath = $dir_path . "/content.txt";
                    
                    if (file_exists($contentPath)) {
                        $content = file_get_contents($contentPath);
                        
                        // Load XML content using a new DOMDocument
                        $dom = new DOMDocument();
                        if ($dom->loadXML($content, LIBXML_NOENT | LIBXML_DTDLOAD)) {
                            $content = htmlspecialchars($dom->saveXML());
                        } else {
                            $content = "XML Error: " . libxml_get_last_error()->message;
                        }
                        
                        $results[] = [
                            'id' => $file,
                            'content' => $content
                        ];
                    }
                }
            }
        }
    }
    
    return $results;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Saved Content</title>
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
        h2 {
            text-align: center;
            font-size: 24px;
        }
        .form-container {
            text-align: center;
        }
        .form-input {
            margin-bottom: 10px;
            text-align: center;
        }
        label {
            display: block;
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
        }
        textarea {
            width: 100%;
            resize: none;
            text-align: center;
            background-color: rgba(255, 255, 255);
        }
        button {
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 24px;
        }
        .button:hover, .button:hover {
            background-color: #0057b3;
        }
        .search-results-box {
            width: 90%;
            max-height: 500px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 24px;
            background-color: white;
        }
    </style>
</head>
<body>
    <h2>Saved Content</h2>
    
    <div class="form-container">
        <form action="content.php" method="POST">
            <div class="form-input">
                <label for="search_term">Search for a note using ID:</label>
                <textarea rows="1" cols="50" name="search_term" id="search_term"></textarea>
            </div>
            <div class="form-input">
                <button type="submit" name="search" class="button">Search</button>
            </div>
        </form>
    </div>
    
    <?php if (!empty($searchResults)): ?>
        <h3>Search Results:</h3>
        <div class="search-results-box">
            <ul>
                <?php foreach ($searchResults as $result): ?>
                    <li>
                        <strong>Note ID:</strong> <?php echo $result['id']; ?><br>
                        <?php echo $result['content']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php
    if (!empty($save_message)) {
        echo "<p>$save_message</p>";
    }
    ?>
</body>
</html>
