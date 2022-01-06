<?php

namespace VChat\classes;

use VChat\db\Sql;

class User
{

  private $conn;
  public $session_id;

  public function __construct()
  {
    $this->conn = new Sql();
    $this->session_id = $this->getSessionId();
  }

  public function isExistentEmail($email)
  {
    $stmt = $this->conn->select(
      "SELECT * FROM users WHERE email = :email;",
      [
        ":email" => $email
      ]
    );

    if ($stmt) {
      return $stmt;

      die();
    }

    return false;
  }

  public function getUsers($user_id_actived)
  {
    $usersArray = $this->conn->select(
      "SELECT * FROM users WHERE id != :id",
      [
        ":id" => $user_id_actived
      ]
    );

    return $usersArray;
  }

  public function getUser($user_id_actived)
  {
    $usersArray = $this->conn->select(
      "SELECT * FROM users WHERE id = :id",
      [
        ":id" => $user_id_actived
      ]
    );

    return $usersArray;
  }

  public function getUserByUsername($username)
  {
    $userArray = $this->conn->select(
      "SELECT * FROM users WHERE username = :username",
      [
        ":username" => $username
      ]
    );

    return $userArray;
  }

  public function updateSession($id)
  {
    $this->conn->query(
      "UPDATE users SET session_id = :sessionId WHERE id = :id",
      [
        ":id" => $id,
        ":sessionId" => $this->session_id,
      ]
    );
  }

  public function updateConnection($id, $connection_id)
  {
    $this->conn->query(
      "UPDATE users SET connection_id = :connection_id WHERE id = :id",
      [
        ":id" => $id,
        ":connection_id" => $connection_id,
      ]
    );
  }

  public function getUserBySession($session_id)
  {
    $userArray = $this->conn->select(
      "SELECT * FROM users WHERE session_id = :sessionId;",
      [
        ":sessionId" => $session_id,
      ]
    );

    return $userArray;
  }

  private function getSessionId()
  {
    return session_id();
  }
}
