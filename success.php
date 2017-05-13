<?php
  session_start();
  if(!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
  } else {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $conn = new mysqli("localhost", "root", "raspberry", "thelocationproject_data");
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
  <link rel="shortcut icon" type="image/x-icon" href="src/favicon.ico">
  <link rel="apple-touch-icon" href="src/favicon.ico">
  <link rel="apple-touch-icon" sizes="152x152" href="src/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="src/favicon.ico">
  <link rel="apple-touch-icon" sizes="167x167" href="src/favicon.ico">
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
          <button class="btn btn-success"><a href="user.php"><?php echo $username; ?></a></button>
          <button class="btn btn-danger"><a href="backend/logout.php">Log Out</a></button>
        </form>
      </div>
    </div>
  </nav>
  <div class="jumbotron">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h1>Hello, <?php echo $username;?></h1>
          <p>Take a look at what you missed.</p>
        </div>
        <div class="col-md-4">
          <h2>New Post</h2>
          <form action="?upload=1" method="post">
            <div class="form-group">
              <label>Tagline of your Party</label>
              <input type="text" class="form-control" name="headline">
            </div>
            <div class="form-group">
              <label>Tell about your Party</label>
              <textarea class="form-control" rows="4" name="txt"></textarea>
            </div>
            <div class="form-group">
              <input class="btn btn-default" type="submit" value="post.">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo "<h2>" .$row["headline"] ."</h2>";
            echo "<h3>Posted by " .$row["author"] ."</h3>";
            echo "<p>" .$row["text"] . "</p>";
            echo "<iframe width='100%' height='50%' frameborder='0' style='border:0'src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAccLsTB--zXURQu1EnGCT_Ml6uY9itHBk&q=" .$row["latitude"] ."," .$row["longitude"] ."&amp" ."' allowfullscreen></iframe>";
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
      header("Location: backend/geolocation.html");
      die();
    } else {
      header("Location: success.php");
      die();
    }
  }
?>
