<?php

// Simple Ratchet WebSocket server

require __DIR__ . '/vendor/autoload.php'; // load composer libs


use Ratchet\MessageComponentInterface;

use Ratchet\ConnectionInterface;

// basic class for handling websockets
class SimpleChat implements MessageComponentInterface
{
    public function onOpen(ConnectionInterface $conn) // when client connects
    {
        echo "Client connected\n"; // log
    }

    public function onMessage(ConnectionInterface $from, $msg) // when message received
    {
        echo "Received: $msg\n"; // print message
        $from->send("Server got: $msg"); // send reply back
    }

    public function onClose(ConnectionInterface $conn) // when client disconnects
    {
        echo "Client disconnected\n"; // log
    }

    public function onError(ConnectionInterface $conn, \Exception $e) // on error
    {
        echo "Error: {$e->getMessage()}\n"; // log
        $conn->close(); // close broken connection
    }
}

$server = Ratchet\App::factory('localhost', 8080); // create server on port 8080
$server->route('/chat', new SimpleChat()); // route /chat to our class
$server->run(); // start server
