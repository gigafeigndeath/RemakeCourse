<?php include 'config.php'; if ($_SESSION['role'] != 'admin') header('Location: login.php'); ?>
<?php include 'includes/header.php'; ?>
<div class="container" style="padding:60px 20px;">
    <h1>Админ-панель</h1>
    <!-- список учеников + чат как в предыдущей версии -->
</div>
<script src="assets/js/chat.js"></script>
<?php include 'includes/footer.php'; ?>
<script>
    myId = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
</script>
<script src="assets/js/chat.js"></script>
<script>
    // функция switchChat остается прежней
    loadHistory(1); // начальный чат
    initWebSocket();
</script>