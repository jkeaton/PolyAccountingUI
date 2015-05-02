<?php
    session_start();
    ob_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
    // Attempt to connect to the SQL Server Database
    $usernameErr = $passErr = "";
    $username = $pass = $hashed_pass = "";
    $utype = 100;
    $uid = -1;
    clear_cookie();

    // Deal with the form being submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle insert event attempt
        if (isset($_POST['submit'])) {
            validateFields();
        }
    }

    function clear_cookie(){
        if(isset($_COOKIE['UserCookie'])) {
            unset($_COOKIE['UserCookie']);
            setcookie('UserCookie', '', time() - 3600); // empty value and old timestamp
        }
    }

    function validateFields(){
        global $usernameErr, $passErr, $username, $pass, $hashed_pass, $utype, $uid;
        $errCount = 0;

        // Get username 
        if (empty($_POST["username"])) {
            ++$errCount;
            $usernameErr = "Username is required";
        } 
        else {
            $username = test_input($_POST["username"]);
        }

        // Get password  
        if (empty($_POST["pass"])) {
            ++$errCount;
            $passErr = "Password is required";
        } 
        else {
            $pass = test_input($_POST["pass"]);
            // hash password for validation (ensure we use the same salt)
            $hashed_pass = crypt($pass, '$5$rounds=5000$bluefootedboobyandbigbrother$');
        }

        if ($errCount == 0){
            if (creds_match()){
                $_POST = array();
                $_SESSION['authenticated'] = true;
                $_SESSION['user'] = $username;
                $_SESSION['db_uid'] = $username;
                $_SESSION['db_pass'] = $pass;
                $_SESSION['level'] = $utype;
                setcookie('UserCookie', $_SESSION['user'], time()+3600, '/');
                if ($_SESSION['level'] === 3){
				    header('Location: /mark_landing/adminpanel.php');
                }
                elseif ($_SESSION['level'] === 2){
				    header('Location: /mark_landing/controlpanel.php');
                }
                elseif ($_SESSION['level'] === 1){
				    header('Location: /mark_landing/controlpanel.php');
                }
                else{
                    var_dump ($_SESSION['level']);
                }
            }
        } 
    }

    function creds_match(){
        global $hashed_pass, $username, $pass, $utype, $uid;     
        try{
            if (isset($username) && isset($pass)){
                $dbConnection = db_connect($username, $pass);
                $sql = ("SELECT [ID] "
                    .",[UserName] "
                    .",[FName] "
                    .",[LName] "
                    .",[Email] "
                    .",[IsLoginDisabled] "
                    .",[Type] "
                    .",[TypeID] "
                    ."FROM [TransactionDB].[dbo].[UserList] "
                    ."WHERE UserName = '".$username."'");
                echo $sql;
                $results = sqlsrv_query($dbConnection, $sql);
                $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
                $utype = $row['TypeID'];
                $uid = $row['ID'];
                return true;
            }
            else{
                return false;
            }
        }
        catch (Exception $e) {
            return false;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Poly Accounting Login</title>

		<!-- Bootstrap -->
		<link href="dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="dist/css/bootstrap.css" rel="stylesheet">
        <!-- Custom Style sheet for moving the body down below nav bar -->
        <link href="dist/css/custom.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

        <script type="text/javascript">
            function clearFields(){
                var fields = document.getElementsByClassName("form-control");
                for each (f in fields){
                    f.value = '';
                }
            }

        </script>
	</head>

	<body role="document" onload="javascript:clearFields()">
    
		<!--main
		================================================== -->
        <div class="row">
            <div class="panel panel-primary col-centered form-group myPanel">
                <div class="panel-heading panel-heading-lg">
                    <img src="dist/images/AppDomainFinalProjectLogo.png" alt="PAI Logo" height="42" width="42" class="logo"> 
                    <h3 class="panel-title panel-title-with-logo">Poly Accounting Information Group</h3>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-signin container-fluid" method="post" id="sign_up_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <h4 class="form-signin-heading">Please sign in</h4>
                        </div>
                        <div class="row">
                            <label for="inputUsername" class="sr-only">Username</label>
                            <input type="text" data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Your username is your first initial followed by your full last name. John Smith's username would be jsmith" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="row no-gutter">
                            <div class="col-xs-6 col-sm-3 left-btn">
                                <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                            </div>
                            <div id="helpLinks" class="col-xs-6 col-sm-6 col-sm-offset-3 text-right right-btn">
                                <a href="passwordreset.php">Forgot my Password</a></br>
                                <a href="newaccount.php">Create new Account</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="errorPane">
                                <span class="error">
                                    <p>
                                        <?php 
                                            if (isset($loginErr)){
                                                echo $loginErr;      
                                                unset($loginErr);
                                            }
                                        ?>
                                    </p>
                                </span> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="dist/js/bootstrap.js"></script>
<script>
    $(document).ready(function(){
        $("[data-toggle='tooltip']").tooltip()
    });
</script>
