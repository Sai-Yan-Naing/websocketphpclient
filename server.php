<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class MyServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    // public function onOpen(ConnectionInterface $conn) {
    //     $this->clients->attach($conn);
    //     echo "New connection! ({$conn->resourceId})\n";
    //     $conn->send("Welcome to the server!");
    // }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
        
        // Send a welcome message to the client
        $conn->send("Welcome to the server!");
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
        $from->send("You said: $msg");
        $from->send("You said: $msg");
        $from->send("You said: $msg");
        $from->send("You said: $msg");
        $from->send("You said: $msg");
        echo "from client data ".$msg;
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyServer()
        )
    ),
    8081
);

echo "Server running at http://localhost:8081\n";

$server->run();
