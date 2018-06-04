<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$server = "192.168.10.201";
$pw = "";
$user = "root";
$db = "fb_test";
// Create connection
$conn = mysqli_connect($server, $user, $pw, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

$post = file_get_contents('php://input');
    $data = json_decode($post);
    // echo $post;
    $sid = $data->sender_id;
    $resid =  $data->recived_time;
    $mid =  $data->mid;
    $txt =  $data->text;
    // echo $data->sender_id

     $sql = "INSERT INTO fb_test (sender_id, recived_time, message_id, message_text) VALUES ('$sid', '$resid', '$mid', '$txt')";

    if ($conn->query($sql) === TRUE) {
    $returnArray['sucess'] = true;
} else {
    $returnArray['sucess'] = false;
}
$conn->close();
echo (json_encode($returnArray));
?>