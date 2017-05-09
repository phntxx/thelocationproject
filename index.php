<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>thelocationproject</title>
  <link href="src/css/bootstrap.min.css" rel="stylesheet">
  <link href="src/css/jumbotron.css" rel="stylesheet">
</head>
<?php
  session_start();
  $pdo = new PDO('mysql:host=localhost;dbname=login', 'root', 'raspberry');
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
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
      $error = true;
    }

    if(strlen($passwort) == 0) {
      echo 'Bitte ein Passwort angeben<br>';
      $error = true;
    }

    if($passwort != $passwort2) {
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
      $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
      $statement = $pdo->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
      $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));
      if($result) {
        echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
        $showFormular = false;
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
      <h1>thelocationproject</h1>
      <p>the new social network that helps you find parties.</p>
      <p><a class="btn btn-primary btn-lg" onclick="showRegister()" role="button">Sign in.</a></p>
    </div>
  </div>
  <div id="registerform">
    <h1>This is my DIV element.</h1>
  </div>
  <hr>
  <footer>
    <p>&copy; 2017 phntxx.</p>
  </footer>
  <script>
    var x = document.getElementByID('registerform');
    x.style.display = 'block';
    function showRegister() {
        var x = document.getElementById('registerform');
	if (x.style.display === 'none') {
            x.style.display = 'block';
        } else {
            x.style.display = 'none';
        }
    }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="src/js/jquery.min.js"><\/script>')</script>
  <script src="src/js/bootstrap.min.js"></script>
</body>
<?php
  }
?>
