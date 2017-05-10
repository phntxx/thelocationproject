<?php
  session_start();

  $latitude = $_POST["lat"];
  $longitude = $_POST["lng"];
  $author = $_SESSION["AUTHOR"];
  $text = $_SESSION["TEXT"];
  $headline = $_SESSION["HEADLINE"];

  echo $latitude;
  echo $longitude;
  echo $author;
  echo $text;
  echo $headline;

  /*
  $pdo = new PDO('mysql:host=localhost;dbname=login', 'root', 'raspberry');
  $statement = $pdo->prepare("INSERT INTO newsfeed (headline, text, author, latitude, longitude) VALUES (:headline, :text, :author, :latitude, :longitude)");
  $result = $statement->execute(array('headline' => $headline, 'text' => $text, 'author' => $author, 'latitude' => $location, 'longitude' => $location));
  if($result) {
    header("Location: success.php");
    die();
  }
  */
?>
