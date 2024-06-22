<?php
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$print = print_r($update, true);
$botToken = "7201459757:AAE7CCAlBLCQ1ouzRva6tNBf3w2WMxoLXT8";
$endpoint = "https://api.telegram.org/bot".$botToken;
if (isset($update['message']['document'])) {
    global $botToken,$endpoint;
    $chatId = $update["message"]["chat"]["id"];
    $file_id = $update['message']['document']['file_id'];
    $file_name = $update['message']['document']['file_name'];
    $message_id = $update["message"]["message_id"];
    $url  = $endpoint.'/getFile?file_id='.$file_id;
    $data = file_get_contents($url);
    $data = json_decode($data,TRUE);
    $file_path = $data['result']['file_path'];
    $file_url = 'https://api.telegram.org/file/bot'.$botToken.'/'.$file_path;
    $document_data = file_get_contents($file_url);
    $put = file_put_contents($file_name,$document_data);
    $linking_data = json_encode(array("filename" => $file_name,"message_id"=>$message_id,"chat_id"=>$chatId));
    file_put_contents("link.json",$linking_data);
    if($put == true){
        shell_exec("php check.php > /dev/null 2>&1 &");
    }else{
        sendMessage($chatId, "I am having problem while getting your combo files", $message_id);
    }

}elseif (isset($update['message'])) {
    $chatId = $update["message"]["chat"]["id"];
    $userId = $update["message"]["from"]["id"];
    $firstname = $update["message"]["from"]["first_name"];
    $username = $update["message"]["from"]["username"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];

    switch (true) {
        case (strpos($message, "/start") === 0):
            sendMessage($chatId, "Hello, $firstname! Welcome to ZCharge.
Please Send CC Combo files to check cc", $message_id);
            break;
        default:
            // Handle unknown commands or messages
            sendMessage($chatId, "I don't understand what you want to mean", $message_id);
    }
}
function sendMessage($chatId, $message, $message_id)
{
    global $endpoint;
    $url = $endpoint."/sendMessage?chat_id="
        . $chatId . "&text=" . urlencode($message) . "&parse_mode=HTML&reply_to_message_id=" . $message_id;
    $data = file_get_contents($url);
    $data = json_decode($data,true);
}
?>