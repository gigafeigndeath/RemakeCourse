<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $pdo;

    public function __construct() {
        global $pdo;
        $this->clients = new \SplObjectStorage;
        $this->pdo = $pdo;
    }

    public function onOpen(ConnectionInterface $conn) { $this->clients->attach($conn); }
    public function onClose(ConnectionInterface $conn) { $this->clients->detach($conn); }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$data['sender_id'], $data['receiver_id'], $data['message']]);

        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'message',
                'from' => $data['sender_id'],
                'to' => $data['receiver_id'],
                'text' => $data['message'],
                'time' => date('H:i')
            ]));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) { $conn->close(); }
}

$server = Ratchet\Server\IoServer::factory(
    new Ratchet\Http\HttpServer(new Ratchet\WebSocket\WsServer(new Chat())),
    8080
);
echo "WebSocket сервер запущен на ws://localhost:8080\n";
$server->run();