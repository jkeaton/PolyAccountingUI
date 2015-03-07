<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect();
    $userEmails = get_user_emails();
    $currUser = $email = $emailErr = "";
    
    // Deal with the form being submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle insert event attempt
        if (isset($_POST['submit'])) {
            validateFields();
        }
    }

    function get_user_emails(){
        global $dbConnection;
        $sql = "select * from AppUser";
        $result = sqlsrv_query( $dbConnection, $sql );
        $output = array();
        while ($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ){
            $output[$row['Email']] = $row['UserName'];
        }
        return $output;
    }

    function validateFields(){
        global $email;
        $errCount = 0;
        if (empty($_POST["email"])) {
            ++$errCount;
            $emailErr = "Email address is required";
        }
        else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                ++$errCount;
                $emailErr = "Invalid email format";
            }
        }
        if ($errCount == 0){
            if (send_reset_code()){
                $_POST = array();
		        //header('Location: verifyresetcode.php');
            }
        }
    } 

    function send_reset_code(){
        global $currUser;
        global $userEmails;
        global $email;
        if ( array_key_exists( $email, $userEmails )){
            $subject = "Poly Accounting Password Reset";
            srand();
            $rand_code = rand();
            $currUser = $userEmails[$email];
            $message = ("Greetings ".$currUser."!\r\n\r\nYour reset code is '".$rand_code."'. Go to the site listed below and enter your reset code in order to reset your account password:\r\nhttp://137.135.120.135/verifyresetcode.php\r\n\r\nWe thank you for your business and hope you have a great day.\r\n\r\nRegards,\r\n\r\nPoly Accounting Information Group");
            $message = wordwrap($message, 70, "\r\n");
            // Send reset email to user
            mail($email, $subject, $message);
            return true;
        }
        else{
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
		<title>Email Verification</title>

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
                            <h4 class="form-signin-heading">Enter your email to receive your password reset link</h4>
                        </div>
                        <div class="row">
                            <label for="inputEmail" class="sr-only">Email</label>
                            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required autofocus>
                        </div>
                        <div class="row no-gutter">
                            <div class="col-xs-6 col-sm-5 left-btn">
                                <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Send Reset Link</button>
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
