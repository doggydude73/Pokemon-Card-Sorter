<?php
	include("Layout.php");

    $db = mysql_connect("localhost","rw","read");
    if (!$db){die('Could not connect to database');}
    mysql_select_db("PokemonCards", $db);

    $user = $_SESSION['user'];
	$type = $_GET['type'];
	$dbSelect = $_GET['db'];
	echo '<table style="width: 800px" cellspacing ="0" cellpadding ="1" border="1">';
	if ($type == "All"){
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
	}else{
		$query = "SELECT * FROM ".$user." WHERE Type = '$type' ORDER BY Type ASC, natDex ASC";
		$sql = mysql_query($query, $db);
		while($row = mysql_fetch_array($sql))
		{
			$color = color($row['type']);
                                       
			echo '<tr>
					<td width ="180" style="Color:'.$color.'">'.$row['name'].'</td>
					<td width ="130" style="Color:'.$color.'">'.$row['ID'].'</td>
					<td width ="180" style="Color:'.$color.'">'.$row['natDex'].'</td>
					<td width ="130" style="Color:'.$color.'">'.$row['type'].'</td>
					<td width ="80"  style="Color:'.$color.'">'.$row['count'].'</td>
				  </tr>';
		}      
	}
	echo '</table>';
?>