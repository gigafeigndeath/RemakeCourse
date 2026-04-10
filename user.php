<?php
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
?>
<?php include 'includes/header.php'; ?>

<div class="container" style="padding:60px 20px; max-width:1200px;">
    <h1>Личный кабинет • <?= htmlspecialchars($_SESSION['full_name'] ?? 'Ученик') ?></h1>
    <h2>Чат с преподавателем</h2>
    
    <div id="chatWindow" style="background:#f8f9fa; border-radius:12px; height:520px; padding:20px; overflow-y:auto; margin-bottom:15px; box-shadow:0 4px 12px rgba(0,0,0,0.1);"></div>
    
    <div style="display:flex; gap:10px;">
        <input type="text" id="msgInput" placeholder="Напишите сообщение..." 
               style="flex:1; padding:15px; border-radius:50px; border:1px solid #ddd; font-size:16px;">
        <button onclick="sendMessage()" 
                style="background:#22c55e; color:white; border:none; padding:0 30px; border-radius:50px; cursor:pointer;">Отправить</button>
    </div>
</div>

<script>
    // Устанавливаем переменные ДО загрузки chat.js
    myId = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
    currentReceiver = 1;           // без let!
</script>

<script src="assets/js/chat.js"></script>

<script>
    // Запускаем после загрузки всех скриптов
    window.onload = function() {
        loadHistory(1);
        initWebSocket();
    };
</script>

<?php include 'includes/footer.php'; ?>