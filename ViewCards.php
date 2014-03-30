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
            <h1>Card Management</h1>

                    <ul>

                        <li>
                            <label>Type:</label>
                            <select name="Type" onchange="getDB()" id="Type">
								<option value="All">All</option>
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
							<label>Database:</label>
							<select name="Type" id="dbSelect">
                                <option value="National">National Database</option>
                                <option value="Personal">Personal</option>
                            </select>
						</li>

                    </ul>

            <p id="test">Below are all of the cards in your current database.</p>
        
            <p>Current Cards:</p>

            <table style="width: 850px" cellspacing="0" cellpadding="0" border="0" >
                <tr>
                    <td>
                        <table border="1" style="width: 800px" cellspacing="0" cellpadding="1">
                            <tr>
                                <th style="width: 180px">Name</th>
                                <th style="width: 130px">Card ID</th>
                                <th style="width: 180px">National Dex ID</th>
                                <th style="width: 130px">Type</th>
                                <th style="width: 80px">Count</th>
                            </tr>
                        </table>
                    </td>
                </tr>
            
                
                 <tr>
                     <td>
                        <div style="width:817px; height:300px; overflow:auto" id="data">
                            <table style="width: 800px" cellspacing ="0" cellpadding ="1" border="1">
                                <?php
                                    $query = "SELECT * FROM ".$user." ORDER BY Type ASC, natDex ASC";
                                    $sql = mysql_query($query, $db);
                                    while($row = mysql_fetch_array($sql))
                                    {
                                        $type = $row['type'];
                                        $color = color($row['type']);
                                       
                                        echo '<tr>
                                            <td width ="180" style="Color:'.$color.'">'.$row['name'].'</td>
                                            <td width ="130" style="Color:'.$color.'">'.$row['ID'].'</td>
                                            <td width ="180" style="Color:'.$color.'">'.$row['natDex'].'</td>
                                            <td width ="130" style="Color:'.$color.'">'.$row['type'].'</td>
                                            <td width ="80"  style="Color:'.$color.'">'.$row['count'].'</td>
                                        </tr>';
                                    }
                                    
                                ?>
                            </table>
                        </div>
                     </td>
                </tr>
            </table>
        </div>
        <div class="background"></div>
    </body>
</html>

<script>
	function getDB()
	{
		var xmlhttp;
		var dbSelect = document.getElementById("dbSelect").value;
		var type = document.getElementById("Type").value;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function ()
		{
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("data").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "fetch.php?db=" + dbSelect + "&type=" + type, true);
		xmlhttp.send();
	}

</script>
