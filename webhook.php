<?php
include '../includes/db.php';
include 'functions.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!isset($update["message"])) exit;

$chat_id = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

if (strpos($text, "/start ") === 0) {
    $param = str_replace("/start ", "", $text); // e.g. content_novel_123

    if (preg_match('/content_(novel|manhwa|anime)_(\d+)/', $param, $matches)) {
        $type = $matches[1]; // novel/manhwa/anime
        $id = (int)$matches[2];

        $tableMap = [
            'novel' => 'novels',
            'manhwa' => 'manhwa',
            'anime' => 'anime'
        ];

        $table = $tableMap[$type];

        $stmt = $conn->prepare("SELECT title, free_link FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $link = $row['free_link'];

            sendTelegramMessage($chat_id, "📘 <b>$title</b>\n\n📥 Free Link:\n$link");
        } else {
            sendTelegramMessage($chat_id, "Content not found.");
        }
    } else {
        sendTelegramMessage($chat_id, "Invalid link. Try again.");
    }
} else {
    sendTelegramMessage($chat_id, "👋 Welcome! Use the 'Read Free' button on our website.");
}
?>