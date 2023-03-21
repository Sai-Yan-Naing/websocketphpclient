<?php
include "./vendor/autoload.php";

$client = new WebSocket\Client("ws://localhost:8081", [], 60);
$client->text('Hello PieSocket!');

// Wait for response from server
try {
    $message = $client->receive();
    print_r($message);
    echo "\n";
} catch (\WebSocket\ConnectionException $e) {
    // Possibly log errors
    print_r("Error: ".$e->getMessage());
}

// Enter while loop to receive messages from server
while (true) {
    try {
        $message = $client->receive();
        print_r($message);
        echo "\n";

    } catch (\WebSocket\ConnectionException $e) {
        // Possibly log errors
        print_r("Error: ".$e->getMessage());
    }
}

$client->close();
?>
