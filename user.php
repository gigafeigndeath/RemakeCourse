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
    
    <div id="chatWindow" class="chat-window"></div>
    
    <div style="display:flex; gap:10px; margin-top:15px;">
        <input type="text" id="msgInput" placeholder="Напишите сообщение..." 
               style="flex:1; padding:15px; border-radius:50px; border:1px solid #ddd; font-size:16px;">
        <button onclick="sendMessage()" 
                style="background:#22c55e; color:white; border:none; padding:0 30px; border-radius:50px; cursor:pointer;">Отправить</button>
    </div>
</div>

<script>
    // ЖЁСТКАЯ УСТАНОВКА ПЕРЕМЕННЫХ (самое важное)
    window.myId = <?= json_encode((int)$_SESSION['user_id']) ?>;
    window.currentReceiver = 1;
    
    console.log('🔥 myId установлен в user.php:', window.myId); // для отладки
</script>

<script src="assets/js/chat.js"></script>

<script>
    window.onload = function() {
        console.log('🚀 onload: myId =', window.myId);
        loadHistory(1);
        initWebSocket();
    };
</script>

<?php include 'includes/footer.php'; ?>