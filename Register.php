<?php
    include 'Layout.php';

    $db = mysql_connect("localhost","root","jasmine");
    if (!$db){die('Could not connect to database');}

    function redirection($website){
        header($website);
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
            
            <?php
                $user;
                $password;
                $confirmPassword;
                $ErrorMessage = "";
                $rolePassword;
                $cardID;
                $cardIDName;

                if(isset($_POST['submit'])){
                    $user = $_POST['user'];
                    $user = verify($user);
                    $password = $_POST['password'];
                    $password = verify($password);
                    $confirmPassword =$_POST['confirmPassword'];
                    $confirmPassword = verify($confirmPassword);
                    $rolePassword = $_POST['rolePassword'];
                    $rolePassword = verify($rolePassword);
                    $cardID = $_POST['cardID'];
                    $cardID = verify($cardID);
                    $cardIDName = $_POST ['idName'];
                    $cardIDName = verify($cardIDName);

                    if ($password != $confirmPassword){
                        $ErrorMessage = "Password and confirmation do not match.";
                        echo $ErrorMessage;}

                    if (strlen($cardID) != 16){
                        $ErrorMessage = "<p style='color:red'>Please enter a valid card ID number.</p>";
                        echo $ErrorMessage;
                    }

                    if (!ctype_alnum($user)){
                        $ErrorMessage = "Your username contains illegal characters.";
                        echo $ErrorMessage;
                    }

                    // All of the information is valid.  Create a new account
                    if ($ErrorMessage == ""){
                        mysql_select_db("Users", $db);
                        
                        // Confirm Role
                        if ($rolePassword == "admin10176"){$rolePassword = "Administrator";}
                        else if ($rolePassword == "operator") {$rolePassword = "Operator";}
                        else {$rolePassword = "New";}

                        // Check to see if the user exists
                        $userLower = strtolower($user);
                        $sql = "SELECT * FROM userprofile WHERE LoginId = '$userLower'";
                        $result = tableQuery($sql, "LoginId", $userLower, $db);

                        if ($result == 0){
                            $sql = "INSERT INTO userprofile (LoginId, Name, CardId, Password, Role) VALUES ('$userLower', '$cardIDName', '$cardID', '$password', '$rolePassword')";
                            if(mysql_query($sql, $db)){

                                // Set up the user's session
                                $_SESSION['user'] = $userLower;
                                $_SESSION['role'] = $rolePassword;
                                $_SESSION['name'] = $cardIDName;

                                // Create the Pokemon Card Table for the other website
                                $sql = "CREATE TABLE ".$userLower." (name varchar(50), ID varchar(50), natDex varchar(50), count varchar(50), type varchar(50), addTime datetime)";
                                mysql_select_db("PokemonCards", $db);
                                mysql_query($sql,$db);

                                mysql_close($db);

                                // Move to the next website
                                $website = "Location: SuccessfulCreation.php";
                                redirection($website);
                            }
                            else{
                                echo '<h1>Failed</h1>';
                            }
                        }
                        else {echo '<h1>Username already exists </h1>';}
                    } 
                    
                }
            ?>

            <form method="post" action="">
            <fieldset>
            <legend>Sign-up Form</legend>
            <ol>
                <li>
                    <label>Username:</label>
                    <input type="text" id="user" name="user" required />
                </li>
                <li>
                    <label>Card ID Name (In full):</label>
                    <input type="text" id="idName" name="idName" required />
                </li>
                <li>
                    <label>Password:</label>
                    <input type="password" id="password" name="password" required/>
                </li>
                <li>
                    <label>Confirm Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required/>
                </li>
                <li>
                    <label>Card ID (Large Number on the bottom of your swipe card):</label>
                    <input type="number" id="cardID" name="cardID"  maxlength="16"/>
                </li>
                <li>
                    <label>Role Password (Can leave blank):</label>
                    <input type="password" id="rolePassword" name="rolePassword" />
                </li>
                <li>
                    <p><input type="submit" name ="submit" value="Submit" /></p>
                </li>
            </ol>
            </fieldset>
            </form>
        </div>
        <div class="background"></div>
    </body>
</html>
