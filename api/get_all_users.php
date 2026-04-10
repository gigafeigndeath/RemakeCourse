<?php
include '../config.php';
header('Content-Type: application/json');
$stmt = $pdo->query("SELECT id, full_name, class, role FROM users ORDER BY role, full_name");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));