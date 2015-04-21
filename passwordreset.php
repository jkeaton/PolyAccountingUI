<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
    // Attempt to connect to the SQL Server Database
    if (isset($_SESSION['db_uid']) && isset($_SESSION['db_pass'])){
        $dbConnection = db_connect($_SESSION['db_uid'], $_SESSION['db_pass']);
    }
    else{
        $dbConnection = db_connect('Noman', 'odysseus');
    }
    $currUser = $username = $usernameErr = "";
    
    // Deal with the form being submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle insert event attempt
        if (isset($_POST['submit'])) {
            validateFields();
        }
    }

    function validateFields(){
        global $username;
        $errCount = 0;
        if (empty($_POST["username"])) {
            ++$errCount;
            $usernameErr = "Username is required";
        }
        else {
            $username = test_input($_POST["username"]);
        }
        if ($errCount == 0){
            if (send_reset_request()){
                $_POST = array();
		        //header('Location: verifyresetcode.php');
            }
        }
    } 

    function send_reset_request(){
        global $username, $dbConnection;
        $date = new DateTime("now");
        $formatted_datetime = $date->format("Y-m-d\TH:i:s");
        $sql = "insert into Email (sender, recipient, [time], [subject], [message], deleted, seen) values ('".$username."', 'admin', CONVERT(datetime, '".$formatted_datetime."', 126), 'password reset', 'Please reset the password for user ''".$username."''.', 0, 0)";
        if (!submit_query($sql)){
            die(php_print(print_r(sqlsrv_errors(), true)));
        }
    }   
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Password Reset</title>

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
	</head>

	<body role="document">
    
		<!--main
		================================================== -->
        <div class="row">
            <div class="panel panel-primary col-centered form-group myPanel">
                <div class="panel-heading-lg panel-heading">
                    <img src="dist/images/AppDomainFinalProjectLogo.png" alt="PAI Logo" height="42" width="42" class="logo"> 
                    <h3 class="panel-title panel-title-with-logo">Poly Accounting Information Group</h3>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-signin container-fluid" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <h4 class="form-signin-heading">Enter your username to send your password reset request</h4>
                        </div>
                        <div class="row">
                            <label for="inputEmail" class="sr-only">Username</label>
                            <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
                        </div>
                        <div class="row no-gutter">
                            <div class="col-xs-6 col-sm-6 left-btn">
                                <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Send Reset Request</button>
                            </div>
                            <div id="returnHome" class="right-btn">
                                <a href="index.php">Return Home</a></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="errorPane">
                                <span class="error">
                                    <p>
                                        <?php 
                                            if (isset($emailErr)){
                                                echo $emailErr;      
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
