<?php
    
    /* 
        Function accepts a query statement and a value to which the statement is looking for.

        Arugment: query - Query Statement
                  field - Field to be queried in each row
                  value - Value user is looking for in the table
                  db    - Database being queried

        Return    1     - A match was found
                  0     - No match found
    */
    function tableQuery($query, $field, $value, $db){
        $sql = mysql_query($query, $db);
        

        while($row = mysql_fetch_array($sql))
        {
            if ($row[$field] == $value){ return 1; }
        }
        return 0;
    }

    /*
        Function escapes any characters the user might put in as an attempt to hack the SQL server
    */
    function verify($word){
        $word = mysql_real_escape_string($word);
        return $word;
    }

    /*
        Function attempts to login a user based upon the passed in username and password.

        Argument: query    - Query Statement containing the "WHERE" clause against the passed in username
                  password - Password passed into to be matched with the username
                  db       - Database to be searched
    */
    function attemptLogin($query, $password, $db){
        $sql = mysql_query($query, $db);

        while($row = mysql_fetch_array($sql))
        {
            if ($row['Password'] == $password){ return $row['Role']; }
        }
        return 0;
    }

    /*
        Function gets the user's card ID to apply to the Hockey and Broomball DBs
   */
    function getId ($db, $user){
        
        mysql_select_db("Users",$db);
        $query = "SELECT * FROM userprofile WHERE LoginId = '$user'";
        $sql = mysql_query($query, $db);
        while($row = mysql_fetch_array($sql))
        {
            $id = $row['CardId'];
        }
        return $id;
    }

    /*
        Function gets the true name of the user currently logged in
    */
    function getName ($query, $db){
        mysql_select_db("Users", $db);
        $sql = mysql_query($query,$db);
        $name = "";
        while($row = mysql_fetch_array($sql))
        {
            $name = $row['Name'];
        }
        return $name;

    }

    /*
        Function determines what role the user is and returns it as a number to make processing easier
    */
    function inRole(){
		if ($_SESSION['role'] == null or !isset($_SESSION['role'])) { return 0; }
        else if ($_SESSION['role'] == "New"){ return 1;}
        else if ($_SESSION['role'] == "User"){ return 2; }
        else if ($_SESSION['role'] == "Operator" ){ return 3;}
        else if ($_SESSION['role'] == "Administrator") {return 4;}
        else if ($_SESSION['role'] == "SuperAdministrator"){return 5;}
        else { return 0; }
    }

    /*
        Function determines if the user has registered for broomball

        Returns:   1 - User is already registered
                   0 - User is not registered
    */
    function isRegistered($name,$db){
        $query = "SELECT teamID FROM registration WHERE name = '".$name."'";
        $sql = mysql_query($query,$db);
        $reg = "0";
        while($row = mysql_fetch_array($sql))
        {
            $reg = "1";
        }

        return $reg;
    }

    /*
        Function syphons the Pokemon List and gets its ID
    */
    function getDex($name, $db){
        $query = "SELECT * FROM PokemonListing";
        $sql = mysql_query($query, $db);
        $dex = "0";

        while ($row = mysql_fetch_array($sql)){
            $rowName = $row['Name'];
            if (stristr($name,$rowName)){
                $dex = $row['ID'];
            }
        }
        return $dex;
    }

    /*
        Function accepts multiple characteristics of a card and uses the properties to return the current count of the card in the database selected (national or local)
    */
    function getCard($dbSelect, $user,$db,$cName,$type,$cDex,$cIN){
        
        $count = "-1";
        // If the select is for local 
        if ($dbSelect == "0"){
            $query = "SELECT count FROM ".$user." WHERE Name = '".$cName."' AND Type = '".$type."' AND natDex = '".$cDex."' AND ID = '".$cIN."'";
            $sql = mysql_query($query, $db);
            
            while ($row = mysql_fetch_array($sql)){
                $count = $row['count'];
            }
        }else if ($dbSelect == "1"){
            // The query is master table
            $query = "SELECT count FROM MasterTable WHERE Name = '".$cName."' AND Type = '".$type."' AND natDex = '".$cDex."' AND ID = '".$cIN."'";
            $sql = mysql_query($query, $db);
            
            while ($row = mysql_fetch_array($sql)){
                $count = $row['count'];
            }
        }
        return $count;
    }

    /*
        Function accepts the type of a card and returns the color that is associated with the type so that the view table can be coloured
    */
    function color($type){
        $color = "#FFFFFF";

        switch($type){
            case "Dark":
                $color = "Grey";
                break;
            case "Dragon":
                $color = "GoldenRod";
                break;
            case "Electric":
                $color = "Yellow";
                break;
            case "Fighting":
                $color = "Brown";
                break;
            case "Fire":
                $color = "Red";
                break;
            case "Grass":
                $color = "GreenYellow";
                break;
            case "Psychic":
                $color = "DarkViolet";
                break;
            case "Steel":
                $color = "Silver";
                break;
            case "Water":
                $color = "#3987c9";
                break;

        }

        return $color;

    }



?>