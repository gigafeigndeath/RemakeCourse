<?php include 'config.php'; 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') header('Location: login.php'); 
?>
<?php include 'includes/header.php'; ?>

<div class="container" style="padding:60px 20px; max-width:900px;">
    <h1>Личный кабинет</h1>
    
    <div style="margin-top:50px;">
        <h2>Чат с наставником</h2>
        <div id="chatWindow" class="chat-window"></div>
        
        <div style="display:flex; gap:12px; margin-top:15px;">
            <input id="msgInput" type="text" style="flex:1; padding:18px; border-radius:9999px; border:1px solid #e2e8f0;" placeholder="Напишите сообщение...">
            <button onclick="sendMessage(document.getElementById('msgInput').value)" 
                    style="background:var(--emerald); color:white; padding:0 40px; border-radius:9999px; border:none; cursor:pointer;">
                Отправить
            </button>
        </div>
    </div>
</div>

<!-- ←←← ЭТО САМОЕ ВАЖНОЕ ИСПРАВЛЕНИЕ -->
<script>
    myId = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;   // ← передаём в JS
    currentReceiver = 1;
</script>
<script src="assets/js/chat.js"></script>
<script>
    loadHistory(1);
    initWebSocket();
</script>

<?php include 'includes/footer.php'; ?>