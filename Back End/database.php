<?php

$config = [
    'server' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'database' => 'connectthread',
];

$db = new mysqli(
    $config["server"],
    $config["username"],
    $config["password"],
    $config["database"]
);

//echo("<script>console.log('PHP: " . json_encode($db) . "');</script>");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>