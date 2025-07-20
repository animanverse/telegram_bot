<?php
// ✅ Check POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("⛔ Only POST allowed.");
}

$link = $_POST['link'] ?? '';
$type = $_POST['type'] ?? '';
$id = $_POST['id'] ?? '';

if (!$link || !$type || !$id) {
    http_response_code(400);
    exit("❌ Missing data.");
}

// ✅ Format message
$typeNames = [
    'novel' => 'Novel',
    'anime' => 'Anime',
    'manhwa' => 'Manhwa'
];

$typeLabel = $typeNames[$type] ?? ucfirst($type);
$message = "$typeLabel ID: $id\n🔗 Link: $link";

// ✅ Telegram credentials
$botToken = "YOUR_TELEGRAM_BOT_TOKEN";
$chatId = "YOUR_CHAT_ID";

// ✅ Send message
$sendUrl = "https://api.telegram.org/bot$botToken/sendMessage";
$params = [
    'chat_id' => $chatId,
    'text' => $message
];

file_get_contents($sendUrl . '?' . http_build_query($params));

// ✅ Response
echo "✅ Message sent to Telegram.";
