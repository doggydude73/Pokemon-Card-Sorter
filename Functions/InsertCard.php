<?php
    /**************************** Maintenence *******************************************/
    session_start();
    $_SESSION['error'] = "";
    $user = $_SESSION['user'];
    include("sql.php");
    date_default_timezone_set("America/Detroit");
    $db = mysql_connect("localhost","root","jasmine");
    mysql_select_db("PokemonCards", $db);

    /************************* Necessary Variables ***************************************/
    $time = date("Y/m/d H:i:s");
    $cName = $_POST['name'];
    $cIN = $_POST['id'];
    $type = $_POST['Type'];
    $count = $_POST['count'];


    /***************************** Begin Work ********************************************/
    if ($type != "Trainer"  && $type != "Energy" && $type != "Stadium"){
        // Card is a Pokemon
        $cDex = getDex($cName, $db);

        $dbCardCount = getCard(0,$user,$db,$cName,$type,$cDex,$cIN);
        $ndbCardCount = getCard(1,$user,$db,$cName,$type,$cDex,$cIN);

    }else if ($type == "Stadium"){
        // Card is a Stadium Card
        $cDex = 1;
        // Check for an unmarked ID
        if ($cIN == ""){$cIN = 0;}

        $dbCardCount = getCard(0,$user,$db,$cName,$type,$cDex,$cIN);
        $ndbCardCount = getCard(1,$user,$db,$cName,$type,$cDex,$cIN);

    }else{
        $cDex = 0;
        // Check for an unmarked ID
        if ($cIN == ""){$cIN = 0;}

        $dbCardCount = getCard(0,$user,$db,$cName,$type,$cDex,$cIN);
        $ndbCardCount = getCard(1,$user,$db,$cName,$type,$cDex,$cIN);
    }

    /* Handle Insertion into the database. 
    All necessary information has been provided */
    if ($dbCardCount == "-1"){
		// Check for escape characters
		$cName = verify($cName);
		$cIN = verify($cIN);
		$type = verify($type);
		$count = verify($count);
            // Card does not already exist
            $query = "INSERT INTO ".$user." VALUES ('$cName', '$cIN', '$cDex','$count','$type','$time')";
            mysql_query($query,$db);
        }else{
            // Card exists. Update the count and time updated
            $lcount = $count + $dbCardCount;
            $query = "UPDATE ".$user." SET Count = '".$lcount."' WHERE Name = '".$cName."' AND Type = '".$type."' AND natDex = '".$cDex."' AND ID = '".$cIN."'";
            mysql_query($query,$db);

            // Update the time modified
            $query = "UPDATE ".$user." SET addTime = '".$time."' WHERE Name = '".$cName."' AND Type = '".$type."' AND natDex = '".$cDex."' AND ID = '".$cIN."'";
            mysql_query($query,$db);
    }

    if ($ndbCardCount == "-1"){
            // Card does not already exist
            $query = "INSERT INTO MasterTable VALUES ('$cName', '$cIN', '$cDex','$count','$type','$time')";
            mysql_query($query,$db);
        }else{
            // Card exists. Update the count and time updated
            $ncount = $count + $ndbCardCount;
            $query = "UPDATE MasterTable SET Count = '".$ncount."' WHERE Name = '".$cName."' AND Type = '".$type."' AND natDex = '".$cDex."' AND ID = '".$cIN."'";
            mysql_query($query,$db);

            // Update the time modified
            $query = "UPDATE MasterTable SET addTime = '".$time."' WHERE Name = '".$cName."' AND Type = '".$type."' AND natDex = '".$cDex."' AND ID = '".$cIN."'";
            mysql_query($query,$db);
    }
    /******************************** End Insertion and Work *********************************/


    header("Location: ../AddCards.php");
?>

