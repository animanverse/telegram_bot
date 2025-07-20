<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

file_put_contents("log.txt", $content . PHP_EOL, FILE_APPEND);

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = $update["message"]["text"];

    if ($text == "/start") {
        $reply = "Welcome to our bot!";
    } else {
        $reply = "You said: " . $text;
    }

    $url = "https://api.telegram.org/bot'8119508260:AAHyCkfoucWWxiJrFbHIzIAJvQZbZKst8a0/sendMessage";
    $data = [
        "chat_id" => $chat_id,
        "text" => $reply,
    ];

    file_get_contents($url . "?" . http_build_query($data));
}
?>
