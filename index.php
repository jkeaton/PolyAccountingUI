<!-- Connect to Database -->
<!--
<?php
    session_start();
    include "dist/common.php";
    $usernameErr = $fnameErr = $lnameErr = $streetErr = $cityErr = $stateErr = $zipcodeErr = $emailErr = $passwordErr = "";
    $username = $fname = $lname = $street = $city = $state = $zipcode = $email = $password = $hashed_pass = "";
    $welcome_msg = "";

    // If the current session includes a valid user, display the welcome label
    if (isset($_SESSION['user'])){
        $welcome_msg = ("Welcome " . $_SESSION['user']);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle logout attempt
        if (isset($_POST['logout'])){
            return logout();
        }

        $errCount = 0;
        // Get username
        if (empty($_POST["username"])) {
            ++$errCount;
            $usernameErr = "Username is required";
        } else {
            $username = test_input($_POST["username"]);
            // only allow alpha digit characters as part of the username
            if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
                ++$errCount;
                $usernameErr = "Only letters and numbers allowed";
            }
            if (!availableUser($username)){
                ++$errCount;
                $usernameErr = "Username is unavailable, please choose another";
            }
        }
    
        // Get fname  
        if (empty($_POST["fname"])) {
            ++$errCount;
            $fnameErr = "First name is required";
        } else {
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
        } else {
            $lname = test_input($_POST["lname"]);
            // only allow alpha characters as part of the last name
            if (!preg_match("/^[a-zA-Z]*$/",$lname)) {
                ++$errCount;
                $lnameErr = "Only letters allowed";
            }
        }

        // Get street 
        if (empty($_POST["street"])) {
            ++$errCount;
            $streetErr = "Street Address is required";
        } else {
            $street = test_input($_POST["street"]);
            // only allow alpha digit characters as part of the street address
            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$street)) {
                ++$errCount;
                $streetErr = "Only letters, numbers and spaces are allowed";
            }
        }
        
        // Get city
        if (empty($_POST["city"])) {
            ++$errCount;
            $cityErr = "City is required";
        } else {
            $city = test_input($_POST["city"]);
            // only allow alpha characters as part of the city
            if (!preg_match("/^[a-zA-Z]*$/",$city)) {
                ++$errCount;
                $cityErr = "Only letters allowed";
            }
        }

        // Get state 
        if (empty($_POST["state"])) {
            ++$errCount;
            $stateErr = "State is required";
        } else {
            $state = test_input($_POST["state"]);
            // only allow alpha characters as part of the state
            if (!preg_match("/^[a-zA-Z]*$/",$state)) {
                ++$errCount;
                $stateErr = "Only letters allowed";
            }
        }

        // Get zipcode
        if (empty($_POST["zipcode"])) {
            ++$errCount;
            $zipcodeErr = "Zipcode is required";
        } else {
            $zipcode = test_input($_POST["zipcode"]);
            // only allow digit characters as part of the zipcode
            if (!preg_match("/^[0-9]*$/",$zipcode)) {
                ++$errCount;
                $zipcodeErr = "Only numbers allowed";
            }
            else{
                if (strlen($zipcode) != 5){
                    ++$errCount;
                    $zipcodeErr = "Zipcode must be 5 digits long";
                }
            }
        }

        // Get email 
        if (empty($_POST["email"])) {
            ++$errCount;
            $emailErr = "Email address is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                ++$errCount;
                $emailErr = "Invalid email format";
            }
        }

        // Get password  
        if (empty($_POST["password"])) {
            ++$errCount;
            $passwordErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
            // hash password for storage
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        }

        // If no errors occured, create a user and store it in the database
        if ($errCount == 0){
            if (createNewAccount($username, $fname, $lname, $street, $city,
                $state, $zipcode, $email, $hashed_pass)){
		        header('Location: http://localhost/TicketHawk/homepage.php');
            }
        }
    }
    
    function createNewAccount($_username, $_fname, $_lname, $_street, $_city, $_state, $_zipcode, $_email, $_password) {
        $dbuser = 'customer';
        $dbpass = 'userpassword';
        $dbhost = 'localhost';
        $dbname = 'tickethawk';
        $cxn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        $query = "INSERT INTO USER
        (username, fname, lname, street_address, city, state, zipcode, email, hashed_pass)
        VALUES ('$_username', '$_fname', '$_lname', '$_street', '$_city', '$_state', '$_zipcode', '$_email', '$_password')";
        $results = mysqli_query($cxn, $query) or die($query);
        return true;
    }
?>
-->

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
            <div class="panel panel-primary col-centered form-group" id="myPanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Poly Accounting Information Group</h3>
                </div>
                <div class="panel-body">
                    <form class="form-signin container-fluid">
                        <div class="row">
                            <h4 class="form-signin-heading">Please sign in</h4>
                        </div>
                        <div class="row">
                            <label for="inputUsername" class="sr-only">Username</label>
                            <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div id="signInButton">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                            </div>
                            <div id="helpLinks">
                                <a href="#">Forgot my Password</a></br>
                                <a href="#">Create new Account</a>
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
