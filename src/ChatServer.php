<?php

namespace Chat;

use Exception;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

final class ChatServer implements MessageComponentInterface{
    private $clients;
    private $colors;

    public function __construct(){
        $this->clients = new SplObjectStorage();
        $this->colors = array();
        echo "Chat inicializado\n";
        // var_dump($this->clients);
    }

    public function onOpen(ConnectionInterface $conn): void{
        $this->clients->attach($conn);
        // var_dump($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg): void{
        $mensagem = json_decode($msg);
        $mensagem->date = date("H:i - d/m/y", time());
        $mensagem->img = $mensagem->nome[0];
        if(!$this->$colors[$mensagem->img]){
            $rgb = array();
            foreach(array('r', 'g', 'b') as $color){
                $rgb[$color] = mt_rand(0, 255);
            }
            $this->$colors[$mensagem->img] = "rgb(".$rgb["r"].",".$rgb["g"].",".$rgb["b"].")";
        }
        $mensagem->color = $this->$colors[$mensagem->img];
        foreach ($this->clients as $client) {
            $client->send(json_encode($mensagem));
        }
        // var_dump($mensagem);
    }

    public function onClose(ConnectionInterface $conn): void{
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $exception): void{
        $conn->close();
    }
}
