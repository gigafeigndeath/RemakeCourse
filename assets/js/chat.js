// assets/js/chat.js — финальная версия с window.
let socket;
let currentReceiver = 1;

window.loadHistory = function(receiver = null) {
    if (receiver !== null) currentReceiver = receiver;

    fetch(`api/get_messages.php?receiver=${currentReceiver}`)
        .then(r => r.json())
        .then(msgs => {
            const win = document.getElementById('chatWindow');
            if (!win) return;
            win.innerHTML = '';
            msgs.forEach(m => {
                const isMe = parseInt(m.sender_id) === parseInt(window.myId);
                const time = m.time || 'сейчас';
                win.innerHTML += `
                    <div class="message ${isMe ? 'message-me' : 'message-them'}">
                        <div class="message-bubble">
                            ${m.message}
                            <div class="message-time">${time}</div>
                        </div>
                    </div>`;
            });
            win.scrollTop = win.scrollHeight;
        });
};

window.sendMessage = function() {
    const input = document.getElementById('msgInput');
    const text = input.value.trim();
    if (!text || !socket) return;

    console.log('Отправка сообщения от myId =', window.myId); // отладка

    socket.send(JSON.stringify({
        sender_id: window.myId,        // ← теперь точно правильный ID
        receiver_id: currentReceiver,
        message: text
    }));

    input.value = '';
    loadHistory();
};

window.initWebSocket = function() {
    if (socket) socket.close();
    socket = new WebSocket('ws://127.0.0.1:8081');
    socket.onmessage = function(e) {
        loadHistory();
    };
};