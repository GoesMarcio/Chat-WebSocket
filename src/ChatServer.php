<?php
//classe do chat extensão de MessageComponentInterface de Ratchet

namespace Chat;

use Exception;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

final class ChatServer implements MessageComponentInterface{
    private $clients; // objeto de clientes conectados
    private $colors; // lista de cores para as letras iniciais

    public function __construct(){
        $this->clients = new SplObjectStorage();
        $this->colors = array();
        echo "Chat inicializado\n";
        // var_dump($this->clients);
    }

    public function onOpen(ConnectionInterface $conn): void{
        // coloca um novo cliente no servidor
        $this->clients->attach($conn);
        // var_dump($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg): void{

        $mensagem = json_decode($msg);
        $mensagem->date = date("H:i - d/m/y", time());
        $mensagem->img = $mensagem->nome[0]; // pega a letra inicial do nome

        //verifica se já existe uma cor para a letra inicial do nome
        if(!$this->$colors[$mensagem->img]){
            // gera uma cor randomica para cada letra inicial de nome
            $rgb = array();
            foreach(array('r', 'g', 'b') as $color){
                $rgb[$color] = mt_rand(0, 255);
            }
            //bota a cor no array na posição da letra
            $this->$colors[$mensagem->img] = "rgb(".$rgb["r"].",".$rgb["g"].",".$rgb["b"].")";
        }
        $mensagem->color = $this->$colors[$mensagem->img];

        //envia a mensagem em json para cada cliente
        foreach ($this->clients as $client) {
            $client->send(json_encode($mensagem));
        }
        // var_dump($mensagem);
    }

    public function onClose(ConnectionInterface $conn): void{
        // retira um cliente do servidor
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $exception): void{
        // se der erro, finaliza o canal com o cliente
        $conn->close();
    }
}
