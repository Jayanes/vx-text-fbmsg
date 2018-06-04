<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$server = "10.30.30.29";
$pw = "t8dcSU";
$user = "root";
$db = "fb_test";
// Create connection
$conn = mysqli_connect($server, $user, $pw, $db,'3306');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

 $post = file_get_contents('php://input');
    $data = json_decode($post);
    // echo $post;
    $sender_id = $data->sender_id;
    $sent_time =  ($data->sent_time)/1000;
    $sent_time =  date('Y-m-d H:i:s', $sent_time);
    $recived_time =  ($data->recived_time)/1000;
    $recived_time =  date('Y-m-d H:i:s', $recived_time);
    $message_id =  $data->message_id;
    $seq_id =  $data->seq_id;
    $msg_text =  $data->msg_text;
    $attachment_type =  $data->attachment_type;
    $attachment_url =  $data->attachment_url;
    // echo $data->sender_id


    // get user details
    $url = "https://graph.facebook.com/v2.6/$sender_id?fields=first_name,last_name&access_token=EAAC8tvGXhg8BALFTtq8SNcWw91fHhOVWU7ZCesTtlpgc0nityiBILBtScdKntIEgcYN0bvPI7YmbCnYFFlP9cgREZAdqJvkjTdkm4jmzkHcNPuM4T0QP3othRGU22vZAhHZAnMke5MbsdHHhnhBqMKzfxmqoNHWXxiHqXAEqqQZDZD";



$userDetails = json_decode(file_get_contents($url));
$f_name = $userDetails->first_name;
$l_name = $userDetails->last_name;

    if($msg_text != null){
        $sql = "INSERT INTO message (sender_id, f_name, l_name, sent_time, recived_time,  message_id, seq_id, msg_text) VALUES ('$sender_id','$f_name','$l_name', '$sent_time', '$recived_time', '$message_id', $seq_id, '$msg_text');";
    }
    elseif ($attachment_type != null) {
        $sql = "INSERT INTO message (sender_id, f_name, l_name, sent_time, recived_time,  message_id, seq_id, attachment_type, attachment_url) VALUES ('$sender_id','$f_name','$l_name', '$sent_time', '$recived_time', '$message_id', $seq_id, '$attachment_type', '$attachment_url');";
    }
    else {
        $sql = "";
    }
    echo $sql;
    if ($conn->query($sql) === TRUE) {
    $returnArray['sucess'] = true;
} else {
    $returnArray['sucess'] = false;
}
$conn->close();
echo (json_encode($returnArray)); 
?>