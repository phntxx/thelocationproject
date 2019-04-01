<?php

  @ob_start();
  session_start();
  $pdo = new PDO('mysql:host=database;dbname=thelocationproject_data', 'root', 'tiger');

  if(isset($_SESSION['username'])){

    $statement = $pdo->prepare('INSERT INTO newsfeed (id, headline, text, author, latitude, longitude) VALUES (:id, :headline, :text, :author, :latitude, :longitude)');
    $result = $statement->execute(array(
      'id' => uniqid(),
      'headline' => $_SESSION['HEADLINE'],
      'text' => $_SESSION['TEXT'],
      'author' => $_SESSION['AUTHOR'],
      'latitude' => $_GET['lat'],
      'longitude' => $_GET['lng']
    ));

    if ($result) {
      $_SESSION['AUTHOR'] = $_SESSION['TEXT'] = $_SESSION['HEADLINE'] = NULL;
      header('Location: ../success.php');
    }
  } else {
    header('Location: ../index.php');
  }
  die();
  
?>
