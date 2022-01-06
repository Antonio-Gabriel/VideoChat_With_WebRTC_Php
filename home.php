<?php

require_once "./core/bootstrap.php";

use VChat\validators\Middleware;
use VChat\classes\User;

$_ = (!Middleware::isAuthenticated()) ? redirect("index.php") : 'IsAuth';

$user = new User();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VChat Dashboard</title>

  <link rel="stylesheet" href="./assets/css/home.css">
</head>

<body>
  <header>
    <div class="container">
      <a href="#" class="logo">VCHAT</a>

      <ul class="menu">
        <li><a href="#">Início</a></li>
        <li><a href="#">Perfil</a></li>
        <li><a href="logout.php">Terminar sessão</a></li>
      </ul>

      <div class="profile">
        <img src="./assets/images/<?= $_SESSION["user"]["photo"] ?>" alt="user">
        <div class="me">
          <span><?= $_SESSION["user"]["name"] ?></span>
          <span>Online</span>
        </div>
      </div>
    </div>
  </header>

  <main>
    <div class="container">
      <div class="content">
        <div class="conections">
          <h2>Conexões</h2>

          <form action="#" class="form-search" autocomplete="off">
            <div class="search">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <input type="text" placeholder="Pesquisar usuário" name="search">
            </div>
          </form>

          <div class="user">
            <h3>Users</h3>

            <ul class="users">
              <?php
              foreach ($user->getUsers($_SESSION["user"]["user_id"]) as $key => $value) {
                $data = (object)$value;
              ?>

                <li>
                  <a href="#">
                    <img src="./assets/images/<?= $data->profile_image ?>" alt="<?= $data->username ?>">

                    <div class="text">
                      <strong><?= $data->username ?></strong>
                      <span>Online</span>
                    </div>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="stream">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
            <path d="M12 2c-4.963 0-9 4.038-9 9 0 3.328 1.82 6.232 4.513 7.79l-2.067 1.378A1 1 0 0 0 6 22h12a1 1 0 0 0 .555-1.832l-2.067-1.378C19.18 17.232 21 14.328 21 11c0-4.962-4.037-9-9-9zm0 16c-3.859 0-7-3.141-7-7 0-3.86 3.141-7 7-7s7 3.14 7 7c0 3.859-3.141 7-7 7z"></path>
            <path d="M12 6c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5zm0 8c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3-1.346 3-3 3z"></path>
          </svg>

          <h2>Manhenta a tua camera conectada</h2>
          <p>Aplicação para streamings e video chamadas</p>

        </div>
        <div class="chat">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
          </svg>

          <h2>Chat</h2>
          <p>Proxima configuração</p>
        </div>
      </div>
    </div>
  </main>

</body>

</html>