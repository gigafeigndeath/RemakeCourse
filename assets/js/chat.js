// assets/js/chat.js — БЕЗ ЕДИНОГО PHP-ТЕГА
let socket;
let currentReceiver = 1;
let myId = 0;   // будет заполнено из PHP

function loadHistory(receiver) {
    fetch(`api/get_messages.php?receiver=${receiver}`)
        .then(r => r.json())
        .then(msgs => {
            const win = document.getElementById('chatWindow');
            win.innerHTML = '';
            msgs.forEach(m => {
                const side = m.sender_id == myId ? 'me' : 'them';
                win.innerHTML += `<div class="${side}"><small>${m.time}</small><div>${m.message}</div></div>`;
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
            win.innerHTML += `<div class="${side}"><small>${d.time}</small><div>${d.text}</div></div>`;
            win.scrollTop = win.scrollHeight;
        }
    };
}

window.sendMessage = function(text) {
    if (!text.trim() || !socket) return;
    socket.send(JSON.stringify({sender_id: myId, receiver_id: currentReceiver, message: text.trim()}));
    document.getElementById('msgInput').value = '';
};