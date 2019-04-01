<?php
  @ob_start();
  session_start();
  $conn = new mysqli("database", "root", "tiger", "thelocationproject_data");

  include_once('head.html');

  $username = $_SESSION['username'];

  if(!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
  }

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if(isset($_GET['upload'])) handleUpload ();
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
        <form class="navbar-form navbar-right">
          <button class="btn btn-success"><a href=<?php echo "user.php?u=" .$username; ?>><?php echo $username; ?></a></button>
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
        $result = $conn->query("SELECT * FROM newsfeed");
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '
              <div class="col-md-4">
                <a href="post.php?id=' . $row['id'] . '">
                  <h2>' . $row['headline'] . '</h2>
                  <h3>Posted by ' . $row['author'] . '</h3>
                  <p>' . adjustText ($row['text']) . '</p>
                </a>
                <iframe width="100%" height="50%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAccLsTB--zXURQu1EnGCT_Ml6uY9itHBk&q=' . $row["latitude"] . ',' . $row["longitude"] . '&amp' . '" allowfullscreen></iframe>
              </div>
            ';
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

  function adjustText ($text) {
    if(strlen($text) > 255){
      return substr($text,0,252);
    } else if(strlen($text) < 255) {
      return str_pad($text, 255);
    } else if (strlen($text) == 255) {
      return $text;
    }
  }

  function handleUpload () {
    $location = $_POST['location'];
    if((strlen($headline) != 0) && (strlen($text) != 0)){
      $_SESSION["AUTHOR"] = $_SESSION['username'];
      $_SESSION["TEXT"] = $_POST['txt'];
      $_SESSION["HEADLINE"] = $_POST['headline'];
      header("Location: backend/geolocation.html");
    } else {
      header("Location: success.php");
    }
    die();
  }
?>
