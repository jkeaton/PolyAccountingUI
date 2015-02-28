<!-- Connect to Database -->
<?php
    include "dist/dbconnect.php";
    include "dist/common.php";
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect();
    $emailErr = $fnameErr = $lnameErr = $passErr = "";
    $email = $fname = $lname = $pass = $hashed_pass = "";

    // Deal with the form being submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle insert event attempt
        if (isset($_POST['submit'])) {
            validateFields();
        }
    }

    function validateFields(){
        global $email, $lname, $fname, $pass, $emailErr, $lnameErr, $fnameErr, $passErr, $hashed_pass;
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

        // Get fname  
        if (empty($_POST["fname"])) {
            ++$errCount;
            $fnameErr = "First name is required";
        } 
        else {
            $fname = test_input($_POST["fname"]);
            // only allow alpha characters as part of the first name
            if (!preg_match("/^[a-zA-Z]*$/",$fname)) {
                ++$errCount;
                $fnameErr = "Only letters allowed";
            }
        }

        // Get lname  
        if (empty($_POST["lname"])) {
            ++$errCount;
            $lnameErr = "Last name is required";
        } 
        else {
            $lname = test_input($_POST["lname"]);
            // only allow alpha characters as part of the last name
            if (!preg_match("/^[a-zA-Z]*$/",$lname)) {
                ++$errCount;
                $lnameErr = "Only letters allowed";
            }
        }

        // Get password  
        if (empty($_POST["pass"])) {
            ++$errCount;
            $passErr = "Password is required";
        } 
        else {
            $pass = test_input($_POST["pass"]);
            // hash password for storage
            $hashed_pass = crypt($pass, '$5$rounds=5000$bluefootedboobyandbigbrother$');
        }

        if ($errCount == 0){
            if (createUser()){
                $_POST = array();
		        header('Location: index.html');
            }
        } 
        else {
            echo "<p>broken!!!</p><br/>";
        }
    }

    function createUser(){
        global $fname, $lname, $email, $hashed_pass, $dbConnection;
        $similar_ct = 0;
        $userNameAttempt = (strtolower($fname)[0].strtolower($lname));
        $sql = "SELECT * FROM AppUser WHERE UserName LIKE '".$userNameAttempt."%'";
        // Ask the database how many usernames begin the same as this one
        $results = sqlsrv_query( $dbConnection, $sql );
        // Modify the attempted username to account for similar ones
        while ($row = sqlsrv_fetch_array( $results, SQLSRV_FETCH_ASSOC)){
            ++$similar_ct;
        } // the php function sqlsrv_num_rows( $results ) is not working for me, but this simple algorithm works
        if ($similar_ct > 0){
            $userNameAttempt = ($userNameAttempt.strval($similar_ct));
        }
        $sql = "INSERT INTO AppUser (UserName, FName, LName, UType, Email, PWHash) VALUES ('".$userNameAttempt."', '".$fname."', '".$lname."', 0, '".$email."', '".$hashed_pass."')";
        $results = sqlsrv_query( $dbConnection, $sql );
        return true;
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
	</head>

	<body role="document">
    
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
                            <h4 class="form-signin-heading">Create a New Account</h4>
                        </div>
                        <div class="row">
                            <label for="inputFname" class="sr-only">First Name</label>
                            <input type="text" name="fname" id="inputFname" class="form-control" placeholder="First Name" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputLname" class="sr-only">Last Name</label>
                            <input type="text" name="lname" id="inputLname" class="form-control" placeholder="Last Name" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputEmail" class="sr-only">Email</label>
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div class="button-left">
                                <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Create Account</button>
                            </div>
                            <div id="helpLinks">
                                <a href="index.php">Return Home</a>
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
