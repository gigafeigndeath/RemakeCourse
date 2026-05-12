<?php
// === Таймзона сразу в самом начале ===
date_default_timezone_set('Asia/Vladivostok');

require_once '../config.php';

header('Content-Type: application/json');

$receiver_id = isset($_GET['receiver']) ? (int)$_GET['receiver'] : 0;
$user_id     = $_SESSION['user_id'] ?? 0;

if ($receiver_id === 0 || $user_id === 0) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            sender_id,
            message,
            DATE_FORMAT(created_at, '%H:%i') as time,
            DATE_FORMAT(created_at, '%Y-%m-%d') as date,
            DATE_FORMAT(created_at, '%d.%m.%Y') as full_date
        FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?) 
           OR (sender_id = ? AND receiver_id = ?)
        ORDER BY created_at ASC
    ");
    
    $stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
} catch (Exception $e) {
    echo json_encode([]);
}
