<?php

namespace VChat\db;

class Sql
{
  public const HOSTNAME = "127.0.0.1";
  public const USERNAME = "root";
  public const PASSWORD = "root";
  public const DBNAME = "vchat";

  private $conn;

  public function __construct()
  {
    $this->conn = new \PDO(
      "mysql:dbname=" . Sql::DBNAME . ";host=" . Sql::HOSTNAME . ";charset=utf8",
      Sql::USERNAME,
      Sql::PASSWORD,
      [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
    );
  }

  private function setParams($statement, $parameters = array())
  {
    foreach ($parameters as $key => $value) {
      $this->bindParam($statement, $key, $value);
    }
  }

  private function bindParam($statement, $key, $value)
  {
    $statement->bindParam($key, $value);
  }

  public function query($rawQuery, $params = array())
  {
    $stmt = $this->conn->prepare($rawQuery);
    $this->setParams($stmt, $params);

    return $stmt->execute();
  }

  public function select($rawQuery, $params = array()): array
  {
    $stmt = $this->conn->prepare($rawQuery);
    $this->setParams($stmt, $params);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function __destruct()
  {
    $this->conn = null;
  }
}
