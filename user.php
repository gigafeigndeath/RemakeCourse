<?php
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<div class="container user-page">
    <div class="profile-header">
        <h1 class="profile-title">Личный кабинет</h1>
        <p class="welcome">Добро пожаловать, <?= htmlspecialchars($_SESSION['full_name'] ?? 'ученик') ?>!</p>
    </div>

    <!-- ЧАТ -->
    <section class="chat-section">
        <h2 class="chat-title">Чат с наставником</h2>
        <div id="chatWindow" class="chat-window"></div>
        
        <div class="chat-input-container">
            <input type="text" id="msgInput" class="chat-input" placeholder="Напишите сообщение...">
            <button onclick="sendMessage(document.getElementById('msgInput').value)" class="btn btn-primary send-btn">Отправить</button>
        </div>
    </section>
</div>

<script>
    let myId = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
    let currentReceiver = 1;
</script>
<script src="assets/js/chat.js"></script>
<script>
    loadHistory(1);
    initWebSocket();
</script>

<?php include 'includes/footer.php'; ?>