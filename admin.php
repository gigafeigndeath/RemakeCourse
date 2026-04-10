<?php
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<?php include 'includes/header.php'; ?>

<div class="container" style="padding:60px 20px; max-width:1400px;">
    <div class="profile-header">
        <h1>Админ-панель • Преподаватель</h1>
        <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Преподаватель') ?>!</p>
    </div>

    <div class="admin-layout" style="display: grid; grid-template-columns: 280px 1fr; gap: 30px; margin-top: 30px;">
        <!-- Список учеников -->
        <div class="students-sidebar">
            <h3>Ученики</h3>
            <div id="studentsList" style="background:#fff; border-radius:12px; padding:10px; box-shadow:0 4px 12px rgba(0,0,0,0.1); max-height:70vh; overflow-y:auto;"></div>
        </div>

        <!-- Чат -->
        <div class="chat-section">
            <h2 id="chatTitle" style="margin-bottom:15px;">Чат с учеником</h2>
            <div id="chatWindow" style="background:#f8f9fa; border-radius:12px; height:520px; padding:20px; overflow-y:auto; margin-bottom:15px; box-shadow:0 4px 12px rgba(0,0,0,0.1);"></div>
            
            <div style="display:flex; gap:10px;">
                <input type="text" id="msgInput" placeholder="Напишите сообщение..." 
                       style="flex:1; padding:15px; border-radius:50px; border:1px solid #ddd; font-size:16px;">
                <button onclick="sendMessage()" 
                        style="background:#22c55e; color:white; border:none; padding:0 30px; border-radius:50px; cursor:pointer;">Отправить</button>
            </div>
        </div>
    </div>

    <!-- Таблица пользователей -->
    <div style="margin-top:60px;">
        <h2>Таблица всех пользователей</h2>
        <table id="usersTable" style="width:100%; border-collapse:collapse; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:20px;">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:12px; text-align:left;">Имя</th>
                    <th style="padding:12px; text-align:left;">Класс</th>
                    <th style="padding:12px; text-align:left;">Роль</th>
                    <th style="padding:12px; text-align:center;">Действия</th>
                </tr>
            </thead>
            <tbody id="usersTableBody"></tbody>
        </table>
    </div>
</div>

<script>
    // Устанавливаем только myId (currentReceiver уже есть в chat.js)
    myId = <?= json_encode($_SESSION['user_id']) ?>;
</script>

<script src="assets/js/chat.js"></script>

<script>
    function loadStudents() {
        fetch('api/get_students.php')
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('studentsList');
                container.innerHTML = '';
                data.forEach(student => {
                    const div = document.createElement('div');
                    div.style.cssText = 'padding:12px 15px; margin:4px 0; border-radius:8px; cursor:pointer; background:#f8fafc;';
                    div.innerHTML = `<strong>${student.full_name}</strong><br><small>Класс: ${student.class || '—'}</small>`;
                    div.onclick = () => {
                        currentReceiver = student.id;
                        document.getElementById('chatTitle').textContent = `Чат с ${student.full_name}`;
                        loadHistory();
                    };
                    container.appendChild(div);
                });
            });
    }

function loadUsersTable() {
    fetch('api/get_all_users.php')
        .then(r => r.json())
        .then(users => {
            const tbody = document.getElementById('usersTableBody');
            tbody.innerHTML = '';
            users.forEach(u => {
                const tr = document.createElement('tr');
                
                let actions = '';
                if (u.role !== 'admin') {
                    actions = `<button onclick="deleteUser(${u.id})" style="background:#ef4444;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;">Удалить</button>`;
                } else {
                    actions = `<span style="color:#64748b; font-size:0.9em; font-weight:500;">Администратор</span>`;
                }

                tr.innerHTML = `
                    <td style="padding:12px;">${u.full_name}</td>
                    <td style="padding:12px;">${u.class || '—'}</td>
                    <td style="padding:12px;">${u.role}</td>
                    <td style="padding:12px; text-align:center;">
                        ${actions}
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
}

    window.deleteUser = function(id) {
        if (confirm('Удалить пользователя?')) {
            fetch('api/delete_user.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id})
            }).then(() => loadUsersTable());
        }
    };

    // Запуск всего после загрузки страницы
    window.onload = function() {
        loadStudents();
        loadUsersTable();
        loadHistory(1);        // начальный чат с первым учеником
        initWebSocket();
    };
</script>

<?php include 'includes/footer.php'; ?>