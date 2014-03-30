<?php
    include 'Layout.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body onload="updateClock(); setInterval('updateClock()', 1000)">
        <?php include 'navBar.php'; ?>
        <div id="main">
            <p id="time"></p>
        </div>
        <div class="background"></div>
        <script>
            function updateClock() {
                var currentTime = new Date();
                document.getElementById("time").innerHTML = currentTime;
            }
        </script>
    </body>
</html>
