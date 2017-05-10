<?php
  session_start();
  if(!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
  } else {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $conn = new mysqli("localhost", "root", "raspberry", "data");
    $sql = "SELECT * FROM newsfeed";
    $result = $conn->query($sql);
    $username = $_SESSION['username'];
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>thelocationproject</title>
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
        <a class="navbar-brand">thelocationproject</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <form class="navbar-form navbar-right">
          <button class="btn btn-danger"><a href="logout.php">Log Out</a></button>
        </form>
      </div>
    </div>
  </nav>
  <div class="jumbotron">
    <div class="container">
      <h1>Hello, <?php echo $username;?></h1>
      <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
      <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h2>New Post</h2>
        <form action="?upload=1" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="headline" placeholder="tagline of your party">
          </div>
          <div class="form-group">
            <textarea rows="4" cols="50" name="txt" placeholder="tell us about your party."></textarea>
          </div>
          <div class="form-group">
            <input class="btn btn-default" type="submit" value="post.">
          </div>
        </form>
      </div>
      <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo "<h2>" .$row["headline"] ."</h2>";
            echo "<h3>Posted in " .$row["latitude"] .$row["longitude"] ." by " .$row["author"] ."</h3>";
            echo "<p>" .$row["text"] . "</p>";
            echo '</div>';
          }
        }
      ?>
    </div>
      <hr>
      <footer>
        <p>&copy; 2015 Company, Inc.</p>
      </footer>
    </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="/src/js/jquery.min.js"><\/script>')</script>
  <script src="/src/js/bootstrap.min.js"></script>
</body>
<?php
  }

  if(isset($_GET['upload'])) {
    $author = $_SESSION['username'];
    $headline = $_POST['headline'];
    $text = $_POST['txt'];
    $location = $_POST['location'];
    if((strlen($headline) != 0) && (strlen($text) != 0)){
      $_SESSION["AUTHOR"] = $author;
      $_SESSION["TEXT"] = $text;
      $_SESSION["HEADLINE"] = $headline;
      header("Location: geolocation.html");
      die();
    } else {
      header("Location: success.php");
      die();
    }
  }
?>
