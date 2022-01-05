<?php

session_start();

$_SESSION = [];

session_destroy();
session_unset();

session_regenerate_id();

header("Location: http://localhost/vchat/index.php");
