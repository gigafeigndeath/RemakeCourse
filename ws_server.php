<?php
// === ВАЖНО: таймзона сразу в самом начале ===
date_default_timezone_set('Asia/Vladivostok');

require __DIR__ . '/vendor/autoload.php';

use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;

require_once 'config.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "✅ WebSocket сервер запущен на ws://127.0.0.1:9002 (Asia/Vladivostok)\n";
    }

    private function getPdo() {
        global $pdo;
        $attempts = 0;
        $maxAttempts = 5;

        while ($attempts < $maxAttempts) {
            try {
                $pdo->query('SELECT 1');
                return $pdo;
            } catch (\Exception $e) {
                $attempts++;
                echo "🔄 Переподключение к MySQL (попытка $attempts)\n";
                require_once 'config.php';
                global $pdo;
                usleep(300000);
            }
        }
        echo "❌ Не удалось восстановить MySQL\n";
        return $pdo;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Новый клиент подключился ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        if ($msg === 'ping') {
            $from->send('pong');
            return;
        }

        $pdo = $this->getPdo();
        if (!$pdo) return;

        $data = json_decode($msg, true);
        if (!isset($data['sender_id'], $data['receiver_id'], $data['message'])) return;

        $sender_id = (int)$data['sender_id'];
        $receiver_id = (int)$data['receiver_id'];
        $message_text = trim($data['message']);

        try {
            $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
            $stmt->execute([$sender_id, $receiver_id, $message_text]);
            echo "✅ Сообщение сохранено (от $sender_id → $receiver_id) в " . date('H:i') . "\n";
        } catch (Exception $e) {
            echo "❌ Ошибка БД: " . $e->getMessage() . "\n";
        }

        $payload = json_encode([
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'message'     => $message_text,
            'time'        => date('H:i'),
            'date'        => date('Y-m-d'),
            'full_date'   => date('d.m.Y')
        ]);

        foreach ($this->clients as $client) {
            $client->send($payload);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Клиент отключился ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ошибка: {$e->getMessage()}\n";
        $conn->close();
    }
};

$server = IoServer::factory(
    new HttpServer(new WsServer(new Chat())),
    9002
);

echo "🚀 WebSocket сервер запущен с правильным часовым поясом на порту 9002!\n";

$server->run();
