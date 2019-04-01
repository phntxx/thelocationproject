<?php
  @ob_start();
  session_start();
  $conn = new mysqli("database", "root", "tiger", "thelocationproject_data");

  include_once('head.html');

  if(!isset($_SESSION['username'])){
    header("Location: ./index.php");
    die();
  }

  $username = $_GET['u'];
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
          <h1><?php echo $username; ?></h1>
          <p>the new social network that helps you find parties.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <h1>Posts</h1>
    <div class="row">
      <?php
        $result = $conn->query("SELECT * FROM newsfeed WHERE author = '$username'");
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
    <h1>Comments</h1>
    <div class="row">
      <?php
        $result1 = $conn->query("SELECT * FROM comments WHERE author = '$username'");
        if ($result1->num_rows > 0) {
          while($row = $result1->fetch_assoc()){
            echo '
            <div class="col-md-3">
              <a href="post.php?id= ' . $row['related_id'] . '">
                <p> ' . $row['text'] . '</p>
              </a>
            </div>
            ';
          }
        }
      ?>
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
  function adjustText ($text) {
    if(strlen($text) > 255){
      return substr($text,0,252);
    } else if(strlen($text) < 255) {
      return str_pad($text, 255);
    } else if (strlen($text) == 255) {
      return $text;
    }
  }
?>
