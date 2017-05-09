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

  //LOGIN FUNCTION
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

  //CHECKING PREVIOUS LOGIN INFO
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
      <p><a class="btn btn-primary btn-lg" href="../login/index.php" role="button">Sign in.</a></p>
    </div>
  </div>
  <hr>
  <footer>
    <p>&copy; 2017 phntxx.</p>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="src/js/jquery.min.js"><\/script>')</script>
  <script src="src/js/bootstrap.min.js"></script>
</body>
<?php
  }
?>
