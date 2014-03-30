<?php
    include("Layout.php");

    $db = mysql_connect("localhost","root","jasmine");
    if (!$db){die('Could not connect to database');}
    mysql_select_db("PokemonCards", $db);

    $user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body onload="document.myForm.name.focus()">
        <?php include 'navBar.php'; ?>
        <div id="main">

            <h1>Card Adder</h1>

            <p>Below is the form for adding cards to your library.  Please fill in all information.  If you have duplicates, you can simply type in the information again and it will add it to the already existing set. To denote a holographic card, add one star at the end of the name and for a first addition, add two stars.</p>

            <p>The table is also sorted with the newest added item at the top of the list.</p>

            <?php
                $Error = $_SESSION['error'];
                if ($Error != ""){
                    echo '<p style="color: red">'.$Error.'</p>';
                }
            ?>

            <form method="post" action="Functions/InsertCard.php" autocomplete="off" name="myForm">
                <fieldset>
                    <legend>Add a Card</legend>
                    <ol>
                        <li>
                            <label>Name:</label>
                            <input type="text" id ="name" name="name" required/>
                        </li>

                        <li>
                            <label>Card ID Number:</label>
                            <input type="number" id ="id" name="id" step="1"/>
                        </li>

                        <li>
                            <label>Type:</label>
                            <select name="Type" required>
                                <option value="Water">Water</option>
                                <option value="Dark">Dark</option>
                                <option value="Dragon">Dragon</option>
                                <option value="Electric">Electric</option>
								<option value="Fighting">Fighting</option>
                                <option value="Fire">Fire</option>
                                <option value="Grass">Grass</option>
                                <option value="Normal">Normal</option>
                                <option value="Psychic">Psychic</option>
                                <option value="Steel">Steel</option>
                                <option value="Trainer">Trainer Card</option>
                                <option value="Stadium">Stadium Card</option>
                                <option value="Energy">Energy Card</option>
                            </select>
                            
                        </li>

                        <li>
                            <label>Card Count:</label>
                            <input type="number" id="count" name="count" step="1" required/>
                        </li>

                        <li>
                            <p><input type="submit" value="Submit"/></p>
                        </li>
                    </ol>
                </fieldset>
            </form>

            <p>Current Cards: </p>
            <table style="width: 600px" cellspacing="0" cellpadding="0" border="0" >
                <tr>
                    <td>
                        <table border="1" style="width: 550px" cellspacing="0" cellpadding="1">
                            <tr>
                                <th style="width: 150px">Name</th>
                                <th style="width: 100px">Card ID</th>
                                <th style="width: 150px">National Dex ID</th>
                                <th style="width: 100px">Type</th>
                                <th style="width: 50px">Count</th>
                            </tr>
                        </table>
                    </td>
                </tr>
            
                
                 <tr>
                     <td>
                        <div style="width:567px; height:100px; overflow:auto">
                            <table style="width: 550px" cellspacing ="0" cellpadding ="1" border="1">
                                <?php
                                    $query = "SELECT * FROM ".$user." ORDER BY addTime DESC LIMIT 30";
                                    $sql = mysql_query($query, $db);
                                    while($row = mysql_fetch_array($sql))
                                    {
                                        echo '<tr>
                                            <td width ="148">'.$row['name'].'</td>
                                            <td width ="100">'.$row['ID'].'</td>
                                            <td width ="150">'.$row['natDex'].'</td>
                                            <td width ="100">'.$row['type'].'</td>
                                            <td width ="52">'.$row['count'].'</td>
                                        </tr>';
                                    }
                                    
                                ?>
                            </table>
                        </div>
                     </td>
            </table>
        </div>
        <div class="background"></div>
    </body>
</html>
