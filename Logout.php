<?php
    session_start();
    $_SESSION['user'] = "";
    $_SESSION['role'] = "";
    $_SESSION['name'] = "";
  
  header("Location: mainPage.php");  
?>