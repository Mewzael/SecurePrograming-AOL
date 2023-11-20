<?php

    $db_host = "127.0.0.1";
    $db_user = "root";
    $db_password = "";
    $db_name = "connectthread";
    try{
        $database = new PDO('mysql:host=localhost;dbname=' . $db_name, $user, $password);
    } catch(Exception $e) {
        echo "Error connecting to db: " . $e->getMessage();
    }
    $database->query("select * from table");
    ?>