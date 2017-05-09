<?php
  session_start();
  $pdo = new PDO('mysql:host=localhost;dbname=login', 'root', 'raspberry');

  if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
      $error = true;
    }

    if(strlen($passwort) == 0) {
      echo 'Bitte ein Passwort angeben<br>';
      $error = true;
    }

    if($passwort != $passwort2) {
      echo 'Die Passwörter müssen übereinstimmen<br>';
      $error = true;
    }

    if(!$error) {
      $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $result = $statement->execute(array('email' => $email));
      $user = $statement->fetch();
      if($user !== false) {
        echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
        $error = true;
      }
    }

    if(!$error) {
      $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
      $statement = $pdo->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
      $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));
      if($result) {
        echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
        $showFormular = false;
      } else {
        echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
      }
    }
  }
?>
