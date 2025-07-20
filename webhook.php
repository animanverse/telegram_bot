<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// ✅ DB connection (your InfinityFree DB)
$host = "sql104.infinityfree.com";
$username = "if0_39327390";
$password = "Manish989887";
$dbname = "if0_39327390_Newsite";

$conn = new mysqli($host, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8mb4");

// ✅ Telegram bot token
$botToken = '8119508260:AAHyCkfoucWWxiJrFbHIzIAJvQZbZKst8a0';

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $text = trim($update["message"]["text"]);

    if ($text === "/start") {
        // ✅ Send welcome + latest book on /start
        $sql = "SELECT title, free_link FROM novels WHERE free_link != '' ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $reply = "🎉 Welcome to Animanverse Bot!\n\nHere's your free link for *" . $book['title'] . "*:\n" . $book['free_link'];
        } else {
            $reply = "Welcome! No books found right now.";
        }
    } else {
        // ✅ User sent a title — search DB
        $stmt = $conn->prepare("SELECT title, free_link FROM novels WHERE title = ? LIMIT 1");
        $stmt->bind_param("s", $text);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $reply = "Here's your free link for *" . $book['title'] . "*:\n" . $book['free_link'];
        } else {
            $reply = "❌ No free link found for \"$text\". Try exact title.";
        }
    }

    // ✅ Send reply to Telegram
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $reply,
        'parse_mode' => 'Markdown'
    ];
    file_get_contents($url . "?" . http_build_query($data));
}
?>
