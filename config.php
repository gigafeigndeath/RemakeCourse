<?php
session_start();
date_default_timezone_set('Asia/Vladivostok');
 try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=itcube;charset=utf8mb4",
        "root",
        "НовыйПароль123",   // ←←← ВСТАВЬ СЮДА СВОЙ ПАРОЛЬ ОТ ROOT
        [
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
$pdo->exec("SET time_zone = '+10:00';");
} catch (PDOException $e) {
    die("Ошибка БД: " . $e->getMessage());
}
?>
