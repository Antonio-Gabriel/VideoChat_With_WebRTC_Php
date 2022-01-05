<?php

require_once "./core/bootstrap.php";

use VChat\validators\Middleware;

$_ = (!Middleware::isAuthenticated()) ? header("Location: " . BASE_URL . "/index.php") : 'IsAuth';



echo $_SESSION["user"]["username"];

?>

<a href="logout.php">logout</a>