<?php

namespace VChat\classes;

use VChat\classes\User;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{
  protected $clients;
  public $user, $data;

  public function __construct()
  {
    $this->clients = new \SplObjectStorage;
    $this->user = new User();
  }

  public function onOpen(ConnectionInterface $conn)
  {
    // Store the new connection to send messages to later
    $queryString = $conn->httpRequest->getUri()->getQuery();
    parse_str($queryString, $query);

    if ($data = (object)$this->user->getUserBySession($query["token"])[0]) {

      $this->data = $data;
      $conn->data = $data;

      $this->clients->attach($conn);
      $this->user->updateConnection($this->data->id, $conn->resourceId);

      echo "New connection! ({$this->data->username})\n";
    }
  }

  public function onMessage(ConnectionInterface $from, $msg)
  {
    $numRecv = count($this->clients) - 1;
    echo sprintf(
      'Connection %d sending message "%s" to %d other connection%s' . "\n",
      $from->resourceId,
      $msg,
      $numRecv,
      $numRecv == 1 ? '' : 's'
    );

    $data = json_decode($msg, true);
    $sendTo = (object)$this->user->getUser(intval($data["sendTo"]))[0];

    $send["sendTo"] = $sendTo->id;

    $send["type"] = $data["type"];
    $send["data"] = $data["data"];

    $send["by"] = $from->data->id;
    $send["username"] = $from->data->username;
    $send["profile_image"] = $from->data->profile_image;


    foreach ($this->clients as $client) {
      if ($from !== $client) {
        // The sender is not the receiver, send to each client connected

        if ($client->resourceId == $sendTo->connection_id || $from == $client) {

          // Send message to other client
          $client->send($msg);
        }
      }
    }
  }

  public function onClose(ConnectionInterface $conn)
  {
    // The connection is closed, remove it, as we can no longer send it messages
    $this->clients->detach($conn);

    echo "Connection {$conn->resourceId} has disconnected\n";
  }

  public function onError(ConnectionInterface $conn, \Exception $e)
  {
    echo "An error has occurred: {$e->getMessage()}\n";

    $conn->close();
  }
}
