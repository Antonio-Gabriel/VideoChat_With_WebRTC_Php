<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once "../bootstrap.php";

use VChat\classes\User;
use VChat\validators\Password;


$user = new User();
$response = $user->isExistentEmail(trim($_POST["email"]));


if ($response) {
  $permition = Password::comparePassword($_POST["password"], $response[0]["password"]);

  if ($permition) {
    session_regenerate_id();

    // Session

    $_SESSION["user"] = [
      "user_id" => $response[0]["id"],
      "username" => $response[0]["username"],
      "name" => $response[0]["name"]
    ];

    header("Location: " . BASE_URL . "/home.php");
  } else {
    header("Location: " . BASE_URL . "/index.php?status=401");
  }
} else {
  header("Location: " . BASE_URL . "/index.php?status=401");
}
