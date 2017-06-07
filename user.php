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
  if(!isset($_SESSION['username'])){
    header("Location: ./index.php");
    die();
  } else {
    $username = $_GET['u'];//$_SESSION['username'];
    $conn = new mysqli("localhost", "root", "raspberry", "thelocationproject_data");
    $sql = "SELECT * FROM newsfeed WHERE author = '$username'";
    $result = $conn->query($sql);

    $sql1 = "SELECT * FROM comments WHERE author = '$username'";
    $result1 = $conn->query($sql1);
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
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo "<a href='post.php?id=" .$row['id'] ."'>";
            echo "<h2>" .$row["headline"] ."</h2>";
            echo "<h3>Posted by " .$row["author"] ."</h3>";
            if(strlen($row["text"]) > 255){
              echo "<p>" .substr($row["text"],0,252) . "...</p>";
            } else if(strlen($row["text"]) < 255){
              echo "<p>" .$longstr = str_pad($row["text"], 255) ."</p>";
            } else if (strlen($row["text"]) == 255){
              echo "<p>" .$row["text"] . "</p>";
            }
            echo "<iframe width='100%' height='50%' frameborder='0' style='border:0'src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAccLsTB--zXURQu1EnGCT_Ml6uY9itHBk&q=" .$row["latitude"] ."," .$row["longitude"] ."&amp" ."' allowfullscreen></iframe>";
	          echo '</div>';
            echo "</a>";
          }
        }
      ?>
    </div>
    <h1>Comments</h1>
    <div class="row">
      <?php
        if ($result1->num_rows > 0) {
          while($row = $result1->fetch_assoc()){
            echo '<div class="col-md-3">';
            echo "<a href=post.php?id='" .$row["related_id"]  ."'>";
            echo "<p>" .$row["text"] ."</p>";
            echo "</a>"
            echo '</div>';
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
  }
?>
