<?php

define("BASE_URL", "http://localhost/vchat");

function redirect(string $location)
{
  header("Location: " . BASE_URL . $location);
}
