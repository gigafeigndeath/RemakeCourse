// assets/js/chat.js — исправленная версия (без перезаписи myId)

let socket = null;
let currentReceiver = 1;

// === ЗАГРУЗКА ИСТОРИИ ===
window.loadHistory = function(receiver = null) {
    if (receiver !== null) currentReceiver = receiver;

    console.log(`📥 Загрузка истории для receiver = ${currentReceiver}`);

    fetch(`api/get_messages.php?receiver=${currentReceiver}`)
        .then(r => r.json())
        .then(msgs => {
            console.log(`📦 Получено ${msgs.length} сообщений`);

            const win = document.getElementById('chatWindow');
            if (!win) return;

            win.innerHTML = '';

            msgs.forEach(m => {
                const isMe = parseInt(m.sender_id) === parseInt(myId || window.myId || 0);

                let dateText = '—';
                if (m.date) {
                    const today = new Date().toISOString().split('T')[0];
                    const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];
                    if (m.date === today) dateText = 'Сегодня';
                    else if (m.date === yesterday) dateText = 'Вчера';
                    else dateText = m.full_date || m.date;
                }

                win.innerHTML += `
                    <div class="message ${isMe ? 'message-me' : 'message-them'}">
                        <div class="message-bubble">
                            ${m.message}
                            <div class="message-time">
                                ${dateText} <span class="time">${m.time || '—'}</span>
                            </div>
                        </div>
                    </div>`;
            });

            win.scrollTop = win.scrollHeight;
        });
};

// === ОТПРАВКА ===
window.sendMessage = function() {
    const input = document.getElementById('msgInput');
    const text = input.value.trim();
    if (!text || !socket) return;

    const currentMyId = myId || window.myId;
    console.log(`🚀 Отправка от myId = ${currentMyId}`);

    socket.send(JSON.stringify({
        sender_id: currentMyId,
        receiver_id: currentReceiver,
        message: text
    }));

    input.value = '';
};

// === WEBSOCKET ===
window.initWebSocket = function() {
    if (socket) socket.close();

    socket = new WebSocket('ws://itcubechat.ru/ws');

    socket.onopen = () => console.log('✅ WebSocket подключён');
    socket.onclose = (e) => console.warn(`⚠️ WebSocket закрыт (код: ${e.code})`);
    socket.onerror = (e) => console.error('❌ WebSocket ошибка', e);

    socket.onmessage = function() {
        console.log('📨 Получено новое сообщение');
        loadHistory();
    };
};

// Автозапуск
window.onload = function() {
    if (typeof myId !== 'undefined' && myId) {
        myId = parseInt(myId);
        console.log(`🔑 myId установлен = ${myId}`);
    } else {
        console.warn('⚠️ myId не найден! Проверь user.php/admin.php');
    }

    initWebSocket();
    loadHistory(1);
};
