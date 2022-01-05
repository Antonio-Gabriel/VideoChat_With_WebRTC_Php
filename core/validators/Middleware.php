<?php

namespace VChat\validators;

session_start();

class Middleware
{

  public static function isAuthenticated(): bool
  {
    if (!isset($_SESSION["user"])) {
      return false;

      die();
    }

    return true;
  }
}
