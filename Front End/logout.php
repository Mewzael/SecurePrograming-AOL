<?php
session_start();

header_remove('X-Powered-By');
header('X-XSS-Protection: 1; mode=block');
header('X-Frame-Options: DENY, SAMEORIGIN');
header('Set-Cookie: SameSite=Strict');

session_destroy();
header("Location: index.php");
?>
