<?php
  session_start();

  if(isset($_SESSION['username'])){
  $latitude = $_GET["lat"];
  $longitude = $_GET["lng"];
  $author = $_SESSION["AUTHOR"];
  $text = $_SESSION["TEXT"];
  $headline = $_SESSION["HEADLINE"];

  $pdo = new PDO('mysql:host=localhost;dbname=data', 'root', 'raspberry');
  $statement = $pdo->prepare("INSERT INTO newsfeed (headline, text, author, latitude, longitude) VALUES (:headline, :text, :author, :latitude, :longitude)");
  $result = $statement->execute(array('headline' => $headline, 'text' => $text, 'author' => $author, 'latitude' => $latitude, 'longitude' => $longitude));
  if($result) {
   $_SESSION["AUTHOR"] = NULL;
   $_SESSION["TEXT"] = NULL;
   $_SESSION["HEADLINE"] = NULL;
    header("Location: success.php");
    die();
  }

  } else {
    header("Location: index.php");
    die();
  }
?>
