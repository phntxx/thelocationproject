<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>thelocationproject</title>
  <link href="src/css/bootstrap.min.css" rel="stylesheet">
  <link href="src/css/jumbotron.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="src/favicon.png">
</head>
<?php
  session_start();
  $pdo = new PDO('mysql:host=localhost;dbname=thelocationproject_data', 'root', 'raspberry');

  if(isset($_GET['login'])){
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $_POST['email']));
    $user = $statement->fetch();
    if ($user !== false && password_verify($_POST['password'], $user['password'])) {
      $_SESSION['username'] = $user['username'];
      header("Location: ./success.php");
      die();
    } else {
      header("Location: ./index.php");
      die();
    }
  }

  if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
      $error = true;
    }

    if(strlen($password) == 0) {
      echo 'Bitte ein Passwort angeben<br>';
      $error = true;
    }

    if($password != $password2) {
      echo 'Die Passwörter müssen übereinstimmen<br>';
      $error = true;
    }

    if(!$error) {
      $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $result = $statement->execute(array('email' => $email));
      $user = $statement->fetch();
      if($user !== false) {
        echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
        $error = true;
      }
    }

    if(!$error) {
      $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
      $result = $statement->execute(array('username' => $username));
      $user = $statement->fetch();
      if($user !== false) {
        echo 'Username taken.<br>';
        $error = true;
      }
    }

    if(!$error) {
      $uuid = uniqid();
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $statement = $pdo->prepare("INSERT INTO users (id, email, password, username) VALUES (:id, :email, :password, :username)");
      $result = $statement->execute(array('id' => $uuid,'email' => $email, 'password' => $password_hash, 'username' => $username));
      if($result) {
        echo 'Du wurdest erfolgreich registriert.';
      } else {
        echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
      }
    }
  }

  if(isset($_SESSION['username'])){
    header("Location: ./success.php");
    die();
  } else {
?>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">thelocationproject</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" method="post" action="?login=1">
          <div class="form-group">
            <input type="text" placeholder="Email" name="email" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" placeholder="Password" name="password" class="form-control">
          </div>
          <button type="submit" class="btn btn-success">Sign up</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="jumbotron">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <center><img src="src/favicon.png"></center>
        </div>
        <div class="col-md-9">
          <h1>thelocationproject</h1>
          <p>the new social network that helps you find parties.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h2>Register</h2>
        <form action="?register=1" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Your Username">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Your E-Mail Address">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Your Password">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password2" placeholder="Confirm your Password">
          </div>
          <div class="form-group">
            <input class="btn btn-default" type="submit" value="Register.">
          </div>
        </form>
      </div>
    </div>
    <hr>
    <footer>
      <p>&copy; 2017 phntxx.</p>
    </footer>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="src/js/jquery.min.js"><\/script>')</script>
  <script src="src/js/bootstrap.min.js"></script>
</body>
<?php
  }
?>
