<?php
include "./vendor/autoload.php";

$client = new WebSocket\Client("ws://localhost:8081");
$client->send('Hello PieSocket!');
// echo json_encode(['test'=>'hello']);die;
while (true) {
    try {
        $message = $client->receive();
        echo json_encode($message);

      } catch (\WebSocket\ConnectionException $e) {
        // Possibly log errors
        print_r("Error: ".$e->getMessage());
    }
}
$client->close();
?>