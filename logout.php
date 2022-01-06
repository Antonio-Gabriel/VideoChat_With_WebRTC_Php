<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once "./config.php";

session_start();

session_destroy();
session_unset();

redirect("index.php");
