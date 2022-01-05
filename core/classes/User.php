<?php

namespace VChat\classes;

use VChat\db\Sql;

class User
{

  private $conn;

  public function __construct()
  {
    $this->conn = new Sql();
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
}
