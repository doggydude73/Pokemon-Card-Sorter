<?php
    include 'Layout.php';
    if ($_SESSION['role'] != "Administrator"  && $_SESSION['role'] != "Operator"){
        header("Location: mainPage.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <?php include 'navBar.php'; ?>
        
        <div id="main">
            <h1>Welcome Operators</h1>

            <p>What can I help you with today operator?</p>
            <ul>   
                <li><a href="../Das/mainPage.php" style="color: #0091ff">Change to Das Website</a></li>
            </ul>   
        </div>
        <div class="background"></div>  
    </body>
</html>
