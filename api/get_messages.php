<?php
include '../config.php';
header('Content-Type: application/json');
$receiver = $_GET['receiver'] ?? 0;
$stmt = $pdo->prepare("SELECT id, sender_id, message, DATE_FORMAT(created_at,'%H:%i') as time 
                       FROM messages 
                       WHERE (sender_id = ? AND receiver_id = ?) 
                          OR (sender_id = ? AND receiver_id = ?) 
                       ORDER BY created_at");
$stmt->execute([$_SESSION['user_id'], $receiver, $receiver, $_SESSION['user_id']]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));