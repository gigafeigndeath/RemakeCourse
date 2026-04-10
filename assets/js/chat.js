let socket;
let currentReceiver = 1;
let myId = 0;

window.loadHistory = function(receiver = null) {
    if (receiver !== null) currentReceiver = receiver;

    fetch(`api/get_messages.php?receiver=${currentReceiver}`)
        .then(r => r.json())
        .then(msgs => {
            const win = document.getElementById('chatWindow');
            if (!win) return;
            win.innerHTML = '';
            msgs.forEach(m => {
                const isMe = parseInt(m.sender_id) === parseInt(myId);
                win.innerHTML += `
                    <div style="margin:12px 0; text-align:${isMe ? 'right' : 'left'};">
                        <div style="display:inline-block; max-width:75%; padding:12px 18px; border-radius:18px;
                                    background:${isMe ? '#22c55e' : '#e5e7eb'}; color:${isMe ? 'white' : 'black'};">
                            <small style="opacity:0.75;">${m.time}</small><br>
                            ${m.message}
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

    socket.send(JSON.stringify({
        sender_id: myId,
        receiver_id: currentReceiver,
        message: text
    }));

    input.value = '';
    loadHistory(); // сразу обновляем чат
};

window.initWebSocket = function() {
    if (socket) socket.close();
    socket = new WebSocket('ws://localhost:8080');
    socket.onmessage = function(e) {
        const data = JSON.parse(e.data);
        if (data.receiver_id == myId || data.sender_id == myId) {
            loadHistory();
        }
    };
};