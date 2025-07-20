<?php
// /bot/functions.php

define('BOT_TOKEN', '8119508260:AAHyCkfoucWWxiJrFbHIzIAJvQZbZKst8a0'); // Replace with actual token

function sendTelegramMessage($chat_id, $text) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];

    file_get_contents($url . "?" . http_build_query($data));
}
