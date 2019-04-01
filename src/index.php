<?php
  @ob_start();
  session_start();
  $pdo = new PDO('mysql:host=database;dbname=thelocationproject_data', 'root', 'tiger');

  include_once('head.html');

  if (isset($_GET['login'])) validateLogin ($pdo);
  if(isset($_GET['register'])) handleRegistration ($pdo);

  if (isset($_SESSION['username'])) {
    header("Location: ./success.php");
    die();
  }
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

  function validateLogin ($pdo) {
    $loginStatement = $pdo -> prepare ("SELECT * FROM users WHERE email = :email");
    $result = $loginStatement -> execute (array(
      'email' => $_POST['email']
    ));
    $user = $loginStatement -> fetch();

    if ($user === true && password_verify($_POST['password'], $user['password'])) {
      $_SESSION['username'] = $user['username'];
      header("Location: ./success.php");
      die();
    } else {
      echo $user;
      //echo password_verify($_POST['password'], $user['password']);
    }

  }

  function validateRegistration ($email, $username, $password, $validatedpassword) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'Please enter a valid email-address<br>';
      return false;
    }

    if (strlen($password) == 0 || strlen($validatedpassword == 0)) {
      echo 'Please enter a password<br>';
      return false;
    }

    if ($password != $validatedpassword) {
      echo "The passwords don't match<br>";
      return false;
    }

    return true;
  }

  function checkIfExists ($type, $value) {
    $statement = $pdo -> prepare ('SELECT * FROM users WHERE ' . $type . ' = :value');
    $result = $statement -> execute (array('value' => $value));
    if (($statement -> fetch()) !== false) {
      echo 'this ' . $type . ' is already taken.';
      return false;
    }
    return true;
  }

  function handleRegistration ($pdo) {
    $validRegistration = validateRegistration ($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password2']);

    if ($validRegistration)  $vaildRegistration = checkIfExists('email', $_POST['email']);
    if ($validRegistration) $vaildRegistration = checkIfExists('username', $_POST['email']);

    if($validRegistration) {
      $statement = $pdo->prepare("INSERT INTO users (id, email, password, username) VALUES (:id, :email, :password, :username)");
      $result = $statement->execute(array('id' => uniqid(),'email' => $_POST['email'], 'password' => password_hash($password, PASSWORD_DEFAULT), 'username' => $_POST['username']));

      echo ($result) ? ('Registration successful.') : ('There was an error while trying to register. Please try again later.');
    }
  }

?>
