<?php
                echo' <ul id="menu">
                <li style="float: left;"><a href="mainPage.php">Home</a></li>';
                
                // User is not logged in
                if (inRole() == 0){
                echo '<li style="float: left"><a href="register.php">Register</a></li>
                      <li style="float: left"><a href="Login.php">Login</a></li>';}

                // User is Logged In
                if (inRole() > 0){
                echo '<li style="float: right"><a href="Logout.php">Logout</a></li>
                      <li style="float: left;"><a href="AddCards.php">Add Cards</a></li>
                      <li style="float: left;"><a href="BuildDeck.php">Build a Deck</a></li>
                      <li style="float: left;"><a href="RemoveCards.php">Remove Cards</a></li>
                      <li style="float: left;"><a href="ViewCards.php">View Cards</a></li> ';
                }
           
                // User is Administrator
                if (inRole() == 4 || inRole() == 5){  
                echo '<li style="float: right;"><a href="AdminControls.php">Administrator Controls</a></li>'; }

                 // User is Operator
                if (inRole() == 3){
                    echo '<li style="float: right;"><a href="OperatorControls.php">Operator Controls </a></li>';
                }

                echo '</ul>';

?>