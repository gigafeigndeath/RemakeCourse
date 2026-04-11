<?php
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
        echo "✅ WebSocket сервер запущен на ws://127.0.0.1:9002\n";
    }

    // Функция пересоздания соединения с БД
    private function getPdo() {
        global $pdo;
        try {
            // Проверяем, живо ли соединение
            $pdo->query('SELECT 1');
        } catch (\Exception $e) {
            // Если умерло — пересоздаём
            require_once 'config.php'; // переподключаемся
            global $pdo;
            echo "🔄 PDO пересоздано\n";
        }
        return $pdo;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Новый клиент подключился ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $pdo = $this->getPdo();   // ← используем свежее соединение

        $data = json_decode($msg, true);
        if (!isset($data['sender_id'], $data['receiver_id'], $data['message'])) {
            echo "❌ Некорректное сообщение\n";
            return;
        }

        $sender_id    = (int)$data['sender_id'];
        $receiver_id  = (int)$data['receiver_id'];
        $message_text = trim($data['message']);

        try {
            $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
            $stmt->execute([$sender_id, $receiver_id, $message_text]);
            echo "✅ Сообщение сохранено в БД (от $sender_id → $receiver_id)\n";
        } catch (Exception $e) {
            echo "❌ Ошибка записи в БД: " . $e->getMessage() . "\n";
        }

        // Рассылаем всем
        $payload = json_encode([
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'message'     => $message_text,
            'time'        => date('H:i')
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
}

$server = IoServer::factory(
    new HttpServer(new WsServer(new Chat())),
    9002
);

echo "🚀 WebSocket сервер запущен и готов к работе на порту 9002!\n";
$server->run();
