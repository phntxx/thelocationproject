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
    $username = $_SESSION['username'];

    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $_SESSION['id'] = $id;
    } else if(isset($_SESSION['id'])){
      $id = $_SESSION['id'];
    } else {
      header("Location: ./success.php");
      die();
    }

    $conn = new mysqli("localhost", "root", "raspberry", "thelocationproject_data");
    $sql = "SELECT * FROM newsfeed WHERE id = '$id'";
    $result = $conn->query($sql);
    $sql1 = "SELECT * FROM comments WHERE related_id = '$id'";
    $result1 = $conn->query($sql1);

    if(isset($_GET['comment'])){
      $related_id = $_SESSION['id'];
      $uuid = uniqid();

      $pdo = new PDO('mysql:host=localhost;dbname=thelocationproject_data', 'root', 'raspberry');
      $statement = $pdo->prepare("INSERT INTO comments (id, related_id, text, author) VALUES (:id, :related_id, :text, :author)");
      $result = $statement->execute(array('id' => $uuid,'related_id' => $related_id, 'text' => $_POST['txt'], 'author' => $username));
      if($result) {
        $_SESSION['id'] = NULL;
        $href = "./post.php?id=" .$related_id;
        header("Location: " .$href);
        die();
      } else {
        header("Location: success.php");
        die("ERROR.");
      }

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
      </div>
    </div>
  </nav>
  <div class='container'>
    <div class='row'>
      <?php
        if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()){
            echo "<h1>" .$row["headline"] ."</h1>";
            echo "<div class='col-md-6'>";
            echo "<p>" .$row["text"] . "</p>";
            echo "</div>";
            echo "<div class='col-md-6'>";
            echo "<iframe width='100%' height='75%' frameborder='0' style='border:0'src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAccLsTB--zXURQu1EnGCT_Ml6uY9itHBk&q=" .$row["latitude"] ."," .$row["longitude"] ."&amp" ."' allowfullscreen></iframe>";
            echo "</div>";
          }
        }
      ?>

      <div class="col-md-3">
        <form action="?comment=1" method="post">
          <div class="form-group">
            <label id="label">What would you like to say?</label>
            <textarea class="form-control" id="textarea" maxlength="140" rows="4" name="txt"></textarea>
          </div>
          <div class="form-group">
            <input class="btn btn-default" id="submitbtn" type="submit" value="post.">
          </div>
        </form>
      </div>

      <?php
        if($result1->num_rows > 0){
          while($row1 = $result1->fetch_assoc()){
            echo "<div class='col-md-3'>";
            echo "<h3>" .$row1["author"] ."</h3>";
            echo "<p>" .$row1["text"] ."</h3>";
            echo "</div>";
          }
        }
      ?>
    </div>
    <hr>
    <footer>
      <p>&copy; 2017 phntxx.</p>
    </footer>
  </div>
  <script>
    var textarea = document.getElementById("textarea");
    var default = "What would you like to say?";
    var submitbutton = document.getElementById("submitbtn");
    var label = document.getElementById("label");
    var check = function() {
      if(textarea.value.length < 140) {
        label.innerHTML = default + " (" + (140 - text.area.value.length) + ")";
        submitbutton.disabled = false;
      } else if(textarea.value.length = 140 || textarea.value.length > 140){
        label.innerHTML = default + " (0!)";
        submitbutton.disabled = true;
      }
    }
    setInterval(check, 100);
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="src/js/jquery.min.js"><\/script>')</script>
  <script src="src/js/bootstrap.min.js"></script>
</body>
<?php
  }
?>
