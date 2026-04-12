<?php
require_once '../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Доступ запрещён']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = (int)$data['user_id'];
$new_role = $data['role']; // 'admin' или 'user'

if ($user_id == 1) {
    echo json_encode(['success' => false, 'error' => 'Нельзя изменить роль главного администратора']);
    exit;
}

$stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
$stmt->execute([$new_role, $user_id]);

echo json_encode(['success' => true]);
