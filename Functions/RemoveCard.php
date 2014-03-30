<?php
    /******************************** Maintenence ****************************************/
    session_start();
    $_SESSION['error'] = "";
    $user = $_SESSION['user'];
    include("sql.php");
    date_default_timezone_set("America/Detroit");
    $db = mysql_connect("localhost","root","jasmine");
    mysql_select_db("PokemonCards", $db);


    /***************************** Necessary Variables ***********************************/
    $time = date("Y/m/d H:i:s");
    $cName = $_POST['name'];
    $cIN = $_POST['id'];
    $type = $_POST['Type'];
    $count = $_POST['count'];

    /********************************* Begin Work ****************************************/
    if ($type != "Trainer"  && $type != "Energy" && $type != "Stadium"){
        // Card is a Pokemon
        $cDex = getDex($cName, $db);
        // Check for an unmarked ID
        if ($cIN == ""){$cIN = 0;}

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

    /************************ Execute Database Management ********************************/
    if ($dbCardCount == -1){
        // The user does not have any cards to remove from his database
        //     the national database.
        $_SESSION['error'] = "Invalid Card Query";
    }else{
        $newDBCount = $dbCardCount - $count;
        $newNDBCount = $ndbCardCount - $count;

        // Local Database
        if ($newDBCount <= 0){
            $query = "DELETE FROM ".$user." WHERE Name = '".$cName."' AND Type = '".$type."' AND ID = '".$cIN."'";
            mysql_query($query,$db);

            // Fix newNDBCount
            $newNDBCount = $ndbCardCount - $dbCardCount;
        }else{
            // Update Count
            $query = "UPDATE ".$user." SET Count = '".$newDBCount."' WHERE Name = '".$cName."' AND Type = '".$type."' AND ID = '".$cIN."'";
            mysql_query($query,$db);

            // Update the time modified
            $query = "UPDATE ".$user." SET addTime = '".$time."' WHERE Name = '".$cName."' AND Type = '".$type."' AND ID = '".$cIN."'";
            mysql_query($query,$db);
        }

        // National Database
        if ($newNDBCount <= 0){
            $query = "DELETE FROM MasterTable WHERE Name = '".$cName."' AND Type = '".$type."' AND ID = '".$cIN."'";
            mysql_query($query,$db);
        }else{
            // Update Count
            $query = "UPDATE MasterTable SET Count = '".$newNDBCount."' WHERE Name = '".$cName."' AND Type = '".$type."' AND ID = '".$cIN."'";
            mysql_query($query,$db);

            // Update the time modified
            $query = "UPDATE MasterTable SET addTime = '".$time."' WHERE Name = '".$cName."' AND Type = '".$type."' AND ID = '".$cIN."'";
            mysql_query($query,$db);
        } 
    }
     /******************************** End Removal and Work *********************************/
    
     header("Location: ../RemoveCards.php");
?>

