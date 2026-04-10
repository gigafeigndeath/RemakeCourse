<?php
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<div class="container admin-page">
    <div class="profile-header">
        <h1 class="profile-title">Админ-панель • Преподаватель</h1>
        <p class="welcome">Добро пожаловать, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Преподаватель') ?>!</p>
    </div>

    <div class="admin-layout">
        <!-- Список учеников -->
        <div class="students-sidebar">
            <h3 class="sidebar-title">Ученики</h3>
            <div id="studentsList" class="students-list"></div>
        </div>

        <!-- Чат -->
        <div class="chat-section">
            <div class="chat-header">
                <h2 id="chatWith" class="chat-title">Чат с учеником</h2>
                <span id="currentStudentName" class="current-student"></span>
            </div>
            <div id="chatWindow" class="chat-window"></div>
            
            <div class="chat-input-container">
                <input type="text" id="msgInput" class="chat-input" placeholder="Напишите сообщение...">
                <button onclick="sendMessage(document.getElementById('msgInput').value)" class="btn btn-primary send-btn">Отправить</button>
            </div>
        </div>
    </div>
</div>

<script>
    let myId = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
    let currentReceiver = 1;        // будет перезаписываться при выборе ученика
    let currentStudentName = '';
</script>

<script src="assets/js/chat.js"></script>

<script>
    // Загружаем список всех учеников
    function loadStudents() {
        fetch('api/get_students.php')
            .then(r => r.json())
            .then(students => {
                const container = document.getElementById('studentsList');
                container.innerHTML = '';
                students.forEach(student => {
                    const div = document.createElement('div');
                    div.className = 'student-item';
                    div.innerHTML = `
                        <strong>${student.full_name}</strong><br>
                        <small>Класс: ${student.class || '—'}</small>
                    `;
                    div.onclick = () => switchToStudent(student.id, student.full_name);
                    container.appendChild(div);
                });
            });
    }

    // Переключение на ученика
    window.switchToStudent = function(studentId, name) {
        currentReceiver = studentId;
        currentStudentName = name;
        
        document.getElementById('chatWith').textContent = 'Чат с учеником';
        document.getElementById('currentStudentName').textContent = name;
        
        loadHistory(studentId);
    };

    // Запуск
    loadStudents();
    loadHistory(1);           // начальный чат (можно с первым учеником)
    initWebSocket();
</script>

<?php include 'includes/footer.php'; ?>