 <?php

  // ini_set('display_errors', 1);
  // error_reporting(E_ALL);

  require_once "./core/bootstrap.php";

  use VChat\classes\User;
  use VChat\validators\Middleware;

  $_ = (!Middleware::isAuthenticated()) ? redirect("index.php") : 'IsAuth';

  $user = new User();
  $user->updateSession($_SESSION["user"]["user_id"]);


  if (isset($_GET["username"]) && !empty($_GET["username"])) {
    $userToConnectData = $user->getUserByUsername($_GET["username"]);

    if (!$userToConnectData) {
      redirect("home.php");
    } elseif ($userToConnectData[0]["username"] == $_SESSION["user"]["username"]) {
      redirect("home.php");
    }
  } else {
    redirect("home.php");
  }

  ?>

 <!DOCTYPE html>
 <html lang="pt-pt">

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
         <li><a href="home.php">Início</a></li>
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
                   <a href="<?= $data->username ?>">
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

           <div class="call" id="call">
             <?php

              foreach ($user->getUserByUsername($_GET["username"]) as $key => $value) {
                # code...
                $userToConnect = (object)$value;
              ?>
               <div class="circle">
                 <img src="./assets/images/<?= $userToConnect->profile_image ?>" alt="<?= $data->username ?>">
               </div>

               <h2 class="connect-name"><?= $userToConnect->name ?></h2>
               <p class="connect-email"><?= $userToConnect->email ?></p>
               <p class="connect-username">@<?= $userToConnect->username ?></p>

               <a class="btn-call" id="callBtn" data-user="<?= $userToConnect->id ?>">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                 </svg>
               </a>
             <?php } ?>
             <span style="display:none; overflow: hidden; " class="token"><?= $user->session_id ?></span>
           </div>

           <div class="video hidden" id="video">
             <video id="localVideo" src=""></video>
             <video id="remoteVideo" src=""></video>
           </div>
         </div>

         <div class="chat">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
           </svg>

           <h2>Chat</h2>
           <p>Proxima configuração</p>
         </div>
       </div>
     </div>
   </main>

   <div class="popup hidden" id="callBox">

     <div class="content">
       <div class="user-info">
         <img src="./assets/images/emptyPhoto.png" alt="username" id="profile_image">
         <div class="info">

           <strong id="username">username</strong>
           <span>
             Chamada
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" s>
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
             </svg>
           </span>
         </div>
       </div>
       <div class="call">
         <svg xmlns="http://www.w3.org/2000/svg" id="declineBtn" class="h-6 w-6" fill="none" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
         </svg>

         <svg xmlns="http://www.w3.org/2000/svg" id="answerBtn" class="h-6 w-6" fill="none" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
         </svg>
       </div>

     </div>

   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>

   <script src="./assets/js/webRTCConnection.js"></script>
 </body>

 </html>