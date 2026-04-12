<?php
include '../config.php';
header('Content-Type: application/json');

$users = [];
$stmt = $pdo->query("SELECT id, full_name, email, role, class FROM users ORDER BY id");
while ($row = $stmt->fetch()) {
    $users[] = $row;
}

echo json_encode($users);
