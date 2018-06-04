<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$server = "10.30.30.29";
$pw = "t8dcSU";
$user = "root";
$db = "fb_test";
// Create connection
$conn = mysqli_connect($server, $user, $pw, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";