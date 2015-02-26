<!-- Connect to Database -->
<?php
    include "dist/dbconnect.php";
    include "dist/common.php";
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect();
    $usernameErr = $passErr = "";
    $username = $pass = $hashed_pass = "";

    // Deal with the form being submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle insert event attempt
        if (isset($_POST['submit'])) {
            validateFields();
        }
    }

    function validateFields(){
        global $usernameErr, $passErr, $username, $pass, $hashed_pass;
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
                // if all's well, let them through to the post-login screen
                // for now we are going directly to the journalentry.php screen
		        header('Location: journalentry.php');
            }
        } 
    }

    function creds_match(){
        global $dbConnection, $hashed_pass, $username;     
        $sql = ("SELECT * FROM AppUser WHERE UserName = '".$username."'");
        $results = sqlsrv_query( $dbConnection, $sql );
        // Only care about the first row (should be the only row)
        $row = sqlsrv_fetch_array( $results, SQLSRV_FETCH_ASSOC);
        if ($hashed_pass !== $row['PWHash']){
            return false;
        }
        else{
            return true;  
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
                <div class="panel-heading">
                    <img src="dist/images/AppDomainFinalProjectLogo.png" alt="PAI Logo" height="42" width="42" class="logo"> 
                    <h3 class="panel-title">Poly Accounting Information Group</h3>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-signin container-fluid" method="post" id="sign_up_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <h4 class="form-signin-heading">Please sign in</h4>
                        </div>
                        <div class="row">
                            <label for="inputUsername" class="sr-only">Username</label>
                            <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div class="button-left">
                                <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                            </div>
                            <div id="helpLinks">
                                <a href="emailverification.php">Forgot my Password</a></br>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
