<?php
  @ob_start();
  session_start();
  $conn = new mysqli("database", "root", "tiger", "thelocationproject_data");
  $pdo = new PDO('mysql:host=database;dbname=thelocationproject_data', 'root', 'tiger');

  require_once('head.html')

  if (isset($_GET['comment'])) postComment();

  if(!isset($_SESSION['username'])){
    header("Location: ./index.php");
    die();
  }

  $username = $_SESSION['username'];

  if (isset($_GET['id'])) $id = $_SESSION['id'] = $_GET['id'];
  if (isset($_SESSION['id'])) $id = $_SESSION['id'];
  if (!isset($_SESSION['id']) && !isset($_GET['id'])) {
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
      </div>
    </div>
  </nav>
  <div class='container'>
    <div class='row'>
      <?php
        $result = $conn->query("SELECT * FROM newsfeed WHERE id = '$id'");
        if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()){
            echo '
              <h1>' . $row['headline'] . '</h1>
              <div class="col-md-6">
                <p>' . $row['text'] . '</p>
              </div>
              <div class="col-md-6">
                <iframe width="100%" height="75%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAccLsTB--zXURQu1EnGCT_Ml6uY9itHBk&q=' .$row["latitude"] . ',' .$row["longitude"] . '&amp' .'" allowfullscreen></iframe>
              </div>
            ';
          }
        }
      ?>
      <hr>
      <div class="col-md-3">
        <form action="?comment=1" method="post">
          <div class="form-group">
            <label id="label"></label>
            <textarea class="form-control" id="textarea" maxlength="140" rows="4" name="txt"></textarea>
          </div>
          <div class="form-group">
            <input class="btn btn-default" id="submitbtn" type="submit" value="post.">
          </div>
        </form>
      </div>
      <?php
        $result1 = $conn->query("SELECT * FROM comments WHERE related_id = '$id'");
        if($result1->num_rows > 0){
          while($row1 = $result1->fetch_assoc()){
            echo '
              <div class="col-md-3">
              <h3> ' . $row1['author'] . '</h3>
              <p> ' . $row1['text']. ' </p>
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
  <script>
    let textarea = document.getElementById ("textarea");
    let submitbutton = document.getElementById ("submitbtn");

    textarea.onchange = function () {
      document.getElementById ("label").innerHTML = "What would you like to say?" + " (" + (140 - textarea.value.length) + ")";
      if (textarea.value.length < 140) {
        submitbutton.disabled = false;
      } else if (textarea.value.length = 140 || textarea.value.length > 140){
        submitbutton.disabled = true;
      }
    }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="src/js/jquery.min.js"><\/script>')</script>
  <script src="src/js/bootstrap.min.js"></script>
</body>
<?php

  function postComment () {
    $statement = $pdo->prepare("INSERT INTO comments (id, related_id, text, author) VALUES (:id, :related_id, :text, :author)");
    $result = $statement->execute(array(
      'id' => uniqid(),
      'related_id' => $_SESSION['id'],
      'text' => $_POST['txt'],
      'author' => $username
    ));

    $_SESSION['id'] = NULL;
    ($result) ? (header("Location: ./post.php?id=" . $related_id)) : (header("Location: success.php"))
    die();
  }

?>
