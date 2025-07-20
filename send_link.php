<?php
session_start();
include 'includes/db.php';

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_GET['book_id'] ?? 0);
$type = $_GET['type'] ?? 'novel';

// ✅ Validate content type
$valid_types = ['novel', 'manhwa', 'anime'];
if (!in_array($type, $valid_types)) die("Invalid type");

$table = ['novel' => 'novels', 'manhwa' => 'manhwa', 'anime' => 'anime'][$type];

// ✅ Fetch free link
$stmt = $conn->prepare("SELECT title, free_link FROM $table WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$book || !$book['free_link']) {
    die("Free link not available.");
}

// ✅ Prepare deep link to your bot with custom payload
$payload = urlencode("book_{$type}_{$book_id}");
$bot_url = "https://t.me/animanverse_bot?start=$payload";

// ✅ Redirect to Telegram bot
header("Location: $bot_url");
exit;
