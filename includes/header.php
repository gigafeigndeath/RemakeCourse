<?php require_once __DIR__ . '/../config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT-КУБ Находка</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">IT<span>КУБ</span><span class="city">НАХОДКА</span></div>
        <nav class="nav" id="nav">
            <a href="index.php">Главная</a>
            <a href="about.php">О нас</a>
            <a href="programs.php">Программы</a>
            <a href="contacts.php">Контакты</a>
        </nav>
        <div class="auth">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= $_SESSION['role']=='admin' ? 'admin.php' : 'user.php' ?>" class="btn-profile">Профиль</a>
                <a href="logout.php" class="btn-logout">Выйти</a>
            <?php else: ?>
                <a href="login.php" class="btn-login">Войти</a>
            <?php endif; ?>
        </div>
        <button class="hamburger" id="hamburger">☰</button>
    </div>
</header>
<script>
document.getElementById('hamburger').onclick = () => document.getElementById('nav').classList.toggle('open');
</script>