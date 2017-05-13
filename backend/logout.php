<?php
  session_start();
  session_unset();
  $_SESSION['username'] = NULL;
  header("Location: index.php");
?>
