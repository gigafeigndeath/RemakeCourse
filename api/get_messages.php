<?php
require '../config.php';
header('Content-Type: application/json');
$receiver = (int)($_GET['receiver'] ?? 1);
$stmt = $pdo->prepare("SELECT sender_id, message, DATE_FORMAT(created_at,'%H:%i') as time FROM messages 
    WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) 
    ORDER BY created_at ASC");
$stmt->execute([$_SESSION['user_id'], $receiver, $receiver, $_SESSION['user_id']]);
echo json_encode($stmt->fetchAll());
?>