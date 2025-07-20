<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// ✅ DB connection (your free hosting DB)
$host = "sql104.infinityfree.com";
$username = "if0_39327390";  // your InfinityFree DB username
$password = "Manish989887"; // your DB password
$dbname = "if0_39327390_Newsite";

$conn = new mysqli($host, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8mb4");

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $text = trim($update["message"]["text"]);

    // Assume user types book title or ID
    $stmt = $conn->prepare("SELECT title, free_link FROM novels WHERE title = ? LIMIT 1");
    $stmt->bind_param("s", $text);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $reply = "Here's your free link for *" . $book['title'] . "*:\n" . $book['free_link'];
    } else {
        $reply = "Sorry, no free link found for \"$text\". Try exact title.";
    }

    // Send reply
    $botToken = '8119508260:AAHyCkfoucWWxiJrFbHIzIAJvQZbZKst8a0';
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $reply,
        'parse_mode' => 'Markdown'
    ];

    file_get_contents($url . "?" . http_build_query($data));
}
?>
