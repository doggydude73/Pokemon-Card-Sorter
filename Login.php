<?php
    include 'Layout.php';

    $db = mysql_connect("localhost","root","jasmine");
    if (!$db){die('Could not connect to database');}
    mysql_select_db("Users", $db);

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

                if(isset($_POST['submit'])){
                    $user = $_POST['username'];
                    $user = verify($user);
                    $password = $_POST['password'];
                    $password = verify($password);

                    $userLower = strtolower($user);

                    $sql = "SELECT * FROM userprofile WHERE LoginId = '$userLower'";
                    $role = attemptLogin($sql, $password, $db);
                    $realName = getName($sql, $db);

                    if ($role != "0"){
                        $_SESSION['user'] = $userLower;
                        $_SESSION['role'] = $role;
                        $_SESSION['name'] = $realName;
                        redirection("Location: SuccessfulLogin.php");
                    }else{
                        echo '<h1>Failed to login.</h1> <p style ="color: #f00"><b> Please check your username and password </b></p>';
                    }
                }
            ?>

            <br>
            <form method="post" action="" autocomplete="off">
                <fieldset>
                    <legend>Log In to Your Account</legend>
                        <ol>
                            <li>
                            <label>Username:</label>
                            <input type="text" id="username" name="username" required/>
                            </li>

                            <li>
                            <label>Password:</label>
                            <input type="password" id="password" name="password" required/>
                            </li>

                            <li>
                            <p><input type="submit" name ="submit" value="Login" /></p>
                            </li>
                        </ol>
                </fieldset>
            </form>    
        </div>
        <div class="background"></div>
    </body>
</html>
