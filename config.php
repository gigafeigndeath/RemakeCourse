<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=itcube;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Ошибка БД");
}
?>