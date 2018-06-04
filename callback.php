<?php
/**
 * Created by PhpStorm.
 * User: Vikum Dheemantha
 * Date: 1/23/2018
 * Time: 12:30 PM
 */
$access_token = "EAAC8tvGXhg8BALFTtq8SNcWw91fHhOVWU7ZCesTtlpgc0nityiBILBtScdKntIEgcYN0bvPI7YmbCnYFFlP9cgREZAdqJvkjTdkm4jmzkHcNPuM4T0QP3othRGU22vZAhHZAnMke5MbsdHHhnhBqMKzfxmqoNHWXxiHqXAEqqQZDZD";
//provided by us
$verify_token = "sha9v5ik94aru65nathisa98ra";
//verify token sent from fb
$hub_verify_token = null;
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
    /*
     * check whether verify token is accepted
     * */
    if ($hub_verify_token === $verify_token) {
        echo $challenge;
    }
}
    $post = file_get_contents('php://input');
    $data = json_decode($post);

$aResponce = array();

//common things
$aResponce['sender_id'] = $data->entry[0]->messaging[0]->sender->id;
$senderId = $data->entry[0]->messaging[0]->sender->id;
$aResponce['sent_time'] = $data->entry[0]->messaging[0]->timestamp;
$aResponce['recived_time'] = $data->entry[0]->messaging[0]->timestamp;
$aResponce['message_id'] = $data->entry[0]->messaging[0]->message->mid;
$aResponce['seq_id'] = $data->entry[0]->messaging[0]->message->seq;
// if it is text
if($data->entry[0]->messaging[0]->message->text != null){
    $aResponce['msg_text'] = $data->entry[0]->messaging[0]->message->text;
}
else{
    $aResponce['msg_text'] = null;
}
// if there is an attachment
if($data->entry[0]->messaging[0]->message->attachments[0]->type != null){
    $aResponce['attachment_type'] = $data->entry[0]->messaging[0]->message->attachments[0]->type;
 $aResponce['attachment_url'] = $data->entry[0]->messaging[0]->message->attachments[0]->payload->url;
}
else{
    $aResponce['attachment_type'] = null;
    $aResponce['attachment_url'] = null;
}
//JSON encode the data
$sResponce = json_encode($aResponce);

// send to the server
$ch = curl_init('http://online2.hutch.lk/test-facebook/fb-api/connect.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $sResponce);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:
application/json','Content-Length: ' . strlen($sResponce)));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);

if(curl_errno($ch))
{
    error_log(curl_error($ch));
}
curl_close($ch);

/*$message = $data->entry[0]->messaging[0]->message->text;
if($message!= null){
error_log("____________________________________________\n");
//error_log("Message: ".$message."\n");
error_log("Message: ".$post."\n");
error_log("____________________________________________\n");
}*/