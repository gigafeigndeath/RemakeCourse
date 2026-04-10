// assets/js/chat.js — обновлённая версия для админа + пользователя
let socket;
let currentReceiver = 1;
let myId = 0;

function loadHistory(receiver) {
    fetch(`api/get_messages.php?receiver=${receiver}`)
        .then(r => r.json())
        .then(msgs => {
            const win = document.getElementById('chatWindow');
            win.innerHTML = '';
            msgs.forEach(m => {
                const side = m.sender_id == myId ? 'me' : 'them';
                let html = `
                    <div class="message ${side}">
                        <div class="message-time">${m.time}</div>
                        <div class="message-text">${m.message}</div>
                `;
                // Кнопка удаления только для админа
                if (document.querySelector('.admin-page')) {
                    html += `<button onclick="deleteMessage(${m.id})" class="delete-btn">✕</button>`;
                }
                html += `</div>`;
                win.innerHTML += html;
            });
            win.scrollTop = win.scrollHeight;
        });
}

function initWebSocket() {
    socket = new WebSocket('ws://localhost:8080');
    socket.onmessage = e => {
        const d = JSON.parse(e.data);
        if (d.to == myId || d.from == myId) {
            const win = document.getElementById('chatWindow');
            const side = d.from == myId ? 'me' : 'them';
            win.innerHTML += `
                <div class="message ${side}">
                    <div class="message-time">${d.time}</div>
                    <div class="message-text">${d.text}</div>
                </div>`;
            win.scrollTop = win.scrollHeight;
        }
    };
}

window.sendMessage = function(text) {
    if (!text.trim() || !socket) return;
    socket.send(JSON.stringify({
        sender_id: myId,
        receiver_id: currentReceiver,
        message: text.trim()
    }));
    document.getElementById('msgInput').value = '';
};

// === НОВАЯ ФУНКЦИЯ ДЛЯ АДМИНА ===
window.deleteMessage = function(messageId) {
    if (!confirm('Удалить это сообщение?')) return;
    
    fetch('api/delete_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: messageId })
    })
    .then(() => loadHistory(currentReceiver)); // перезагружаем чат
};