<?php

require_once dirname(__DIR__). "/vendor/autoload.php";

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

use VChat\classes\Chat;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8090
);

$server->run();