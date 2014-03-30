<?php
	session_start();
    $_SESSION['role'] = "0";
    $_SESSION['compliance'] = "yes";
    $_SESSION['error'] = "";
	header("Location: mainPage.php");
?>
