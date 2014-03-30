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
    <body>
        <?php include 'navBar.php'; ?>
        <div id="main">
            <h1>Card Remover</h1>

            <p>If there are extra cards in your library or you wish to simply remove all specific cards from your library, type in the relevant information about the card and the card will be removed.  The database is below for your convenience. Please note the number of cards can not be below zero.</p>

            <p>Also for your convenience, the cards are sorted by the time and date added with the most recent being placed at the top. If you would like them sorted normally, simply switch to the current database page.</p>

            <?php
                $Error = $_SESSION['error'];
                if ($Error != ""){
                    echo '<p style="color: red">'.$Error.'</p>';
                }
            ?>

            <form method="post" action="Functions/RemoveCard.php" autocomplete="off" name="myForm">
                <fieldset>
                    <legend>Remove a Card</legend>
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
                                <option value="Fire">Fire</option>
                                <option value="Grass">Grass</option>
                                <option value="Fighting">Fighting</option>
                                <option value="Normal">Normal</option>
                                <option value="Psychic">Psychic</option>
                                <option value="Steel">Steel</option>
                                <option value="Trainer">Trainer Card</option>
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
            <table width="600" cellspacing="0" cellpadding="0" border="0" >
                <tr>
                    <td>
                        <table border="1" cellspacing="0" cellpadding="1" width="550">
                            <tr>
                                <th width ="150">Name</th>
                                <th width ="100">Card ID</th>
                                <th width ="150">National Dex ID</th>
                                <th width = "100">Type</th>
                                <th width = "50">Count</th>
                            </tr>
                        </table>
                    </td>
                </tr>
            
                
                 <tr>
                     <td>
                        <div style="width:567px; height:100px; overflow:auto">
                            <table cellspacing ="0" cellpadding ="1" border="1" width="550">
                                <?php
                                    $query = "SELECT * FROM ".$user." ORDER BY addTime DESC";
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
