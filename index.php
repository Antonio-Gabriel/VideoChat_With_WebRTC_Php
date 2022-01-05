<?php

require_once "./core/bootstrap.php";

use VChat\validators\Middleware;

$_ = (Middleware::isAuthenticated()) ? redirect("/home.php") : 'NotIsAuth';
?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VChat</title>

  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
  <header>
    <div class="container">
      <a href="#" class="logo">VCHAT</a>
    </div>
  </header>

  <main>
    <div class="container">
      <section class="content">
        <div class="text">
          <h1>Sign in to </h1>
          <h2>VChat Platafform</h2>

          <p>Plataforma para <span>live chat</span>, daily e meetings</p>

          <img src="./assets/images/avatar.png" alt="avatar">
        </div>
        <div class="signIn">
          <form action="./core/classes/Signin.php" method="post" class="form" name="form" onsubmit="return validateForm()">

            <h3>Sign In</h3>

            <div class="msg">
              <?php
              $status = (int)$_GET["status"];

              if ($status == 401) {

                echo '<span id="global-error">Acesso Negado!, tente novamente</span>';
              }
              ?>
              <span id="global-error"></span>
            </div>

            <div class="email">
              <input type=" text" id="email" name="email" placeholder="Email">
              <span id="email-error"></span>
            </div>

            <div class="pass">
              <input type="password" id="pass" name="password" placeholder="Password" max="30">
              <span id="pass-error"></span>

              <label for="visibility" class="visibility">
                <input type="checkbox" id="visibility">
                <span>Mostrar password</span>
              </label>
            </div>

            <button type="submit">Login</button>
          </form>
        </div>
      </section>
    </div>
  </main>

  <script src="./assets/js/validator.js"></script>
</body>

</html>

<!-- <script>
    var conn = new WebSocket('ws://localhost:8090');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        console.log(e.data);
    };
</script> -->