<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("Location: index.php");
  die();
}
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>new post</title>
  <link href="src/css/bootstrap.min.css" rel="stylesheet">
  <link href="src/css/jumbotron.css" rel="stylesheet">
</head>
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
        <a class="navbar-brand" href="#">Project name</a>
      </div>
    </div>
  </nav>
  <div class="jumbotron">
    <div class="container">
      <h1>Hello, world!</h1>
      <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
      <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <form action="?upload=1" method="post">
          <input type=text name="headline" placeholder="tagline of your party">
          <br>
          <input type=text name="location" placeholder="in which city is your party?">
          <br>
          <textarea rows="4" cols="50" name="txt" placeholder="tell us about your party."></textarea>
          <input class="btn btn-default" type="submit" value="post.">
        </form>
      </div>
    </div>
    <hr>
    <footer>
      <p>&copy; 2015 Company, Inc.</p>
    </footer>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="src/js/jquery.min.js"><\/script>')</script>
  <script src="src/js/bootstrap.min.js"></script>
</body>
<?php
  if(isset($_GET['upload'])) {
    $author = $_SESSION['username'];
    $headline = $_POST['headline'];
    $text = $_POST['txt'];
    $location = $_POST['location'];
    $pdo = new PDO('mysql:host=localhost;dbname=data', 'root', 'raspberry');
    if(isset($headline) && isset($text) && isset($location)){
      $statement = $pdo->prepare("INSERT INTO newsfeed (headline, text, author, latitude, longitude) VALUES (:headline, :text, :author, :latitude, :longitude)");
      $result = $statement->execute(array('headline' => $headline, 'text' => $text, 'author' => $author, 'latitude' => $location, 'longitude' => $location));
      if($result) {
        header("Location: success.php");
        die();
      } else {
        header("Location: upload.php");
        die();
      }
    } else {
      header("Location: success.php");
      die();
    }
  }
?>
