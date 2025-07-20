<?php
// /bot/setWebhook.php

define('BOT_TOKEN', '8119508260:AAHyCkfoucWWxiJrFbHIzIAJvQZbZKst8a0');
define('WEBHOOK_URL', 'https://Animanverse.free.nf/bot/webhook.php'); // Live domain!

$url = "https://api.telegram.org/bot" . BOT_TOKEN . "/setWebhook?url=" . WEBHOOK_URL;

$response = file_get_contents($url);
echo $response;
