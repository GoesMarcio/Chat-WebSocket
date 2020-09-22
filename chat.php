<?php
// inicialização do servidor WebSocket

require './vendor/autoload.php';

use Chat\ChatServer;

$app = new Ratchet\App('localhost', 9990); // inicializa o Ratchet em localhost e porta 9990
$app->route('/chat', new ChatServer, ['*']); // adiciona a rota do chat
$app->run(); // começa a rodar o servidor
