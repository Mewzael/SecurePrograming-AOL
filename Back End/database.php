<?php

    $db_host = "127.0.0.1";
    $db_user = "root";
    $db_password = "";
    $db_name = "connectthread";
    
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>