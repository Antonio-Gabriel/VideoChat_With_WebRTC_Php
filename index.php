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
          <form action="#" method="post" class="form">
            <h3>Sign In</h3>

            <input type="text" placeholder="Email" required>
            <input type="password" placeholder="Password" required>

            <button>Login</button>
          </form>
        </div>
      </section>
    </div>
  </main>
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