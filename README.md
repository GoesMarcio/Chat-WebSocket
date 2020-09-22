# Chat-WebSocket


Sistema de chat de usuários, no qual os usuários enviam mensagens para todos os usuários que estão online. A aplicação foi desenvolvido utilizando a biblioteca Ratchet em PHP, que implementa um servidor WebSocket.

### Recursos utilizados:
 - [Ratchet](http://socketo.me/)
 - [FontAwesome](https://fontawesome.com/)

### Instalação e execução

Para a execução do script é necessário o [Composer](https://getcomposer.org/).

Faça o clone desse repositório:
```sh
$ git clone https://github.com/GoesMarcio/Chat-WebSocket.git
```

Para iniciar o servidor WebSocket é necessário instalar as dependências através do composer:

```sh
$ composer install
```


Iniciando o servidor:

```bash
$ php chat.php
```

Agora que nosso servidor está rodando, basta abrir o arquivo `index.html` em algum browser.