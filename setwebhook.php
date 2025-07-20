<?php
$botToken ="8119508260:AAHyCkfoucWWxiJrFbHIzIAJvQZbZKst8a0";
$webhookURL = "https://telegram-bot1-p1gk.onrender.com/webhook.php";

$url = "https://api.telegram.org/bot$botToken/setWebhook?url=" . urlencode($webhookURL);
$response = file_get_contents($url);
echo $response;
?>
